<?php

namespace App\Http\Controllers;

use App\Models\ChatConversation;
use App\Models\ChatMessage;
use App\Models\User;
use App\Events\MessageSent;
use App\Events\ConversationUpdated;
use App\Services\OpenRouterService;
use App\Services\GeminiService;
use App\Services\AiContextBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ChatController extends Controller
{
    public function initConversation(Request $request)
    {
        $sessionId = $request->cookie('chat_session_id') ?? Str::uuid()->toString();
        
        $conversation = ChatConversation::firstOrCreate(
            ['session_id' => $sessionId],
            [
                'user_id' => auth()->check() ? auth()->id() : null,
                'customer_name' => auth()->check() ? auth()->user()->name : 'Guest',
                'customer_email' => auth()->check() ? auth()->user()->email : null,
                'status' => 'Open',
                'ai_active' => true,
                'needs_admin' => false,
                'last_activity' => now(),
            ]
        );

        return response()->json([
            'conversation' => $conversation->load('messages.sender'),
            'session_id' => $sessionId,
        ])->cookie('chat_session_id', $sessionId, 60 * 24 * 30); // 30 days
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'session_id' => 'required|string',
            'message' => 'required|string',
        ]);

        $conversation = ChatConversation::where('session_id', $request->session_id)->firstOrFail();
        
        $provider = config('ai.provider', 'gemini');
        $aiService = ($provider === 'openrouter')
            ? app(OpenRouterService::class)
            : app(GeminiService::class);

        // Update conversation customer info if provided
        if ($request->filled('customer_name') || $request->filled('customer_email')) {
            $conversation->update([
                'customer_name' => $request->input('customer_name', $conversation->customer_name),
                'customer_email' => $request->input('customer_email', $conversation->customer_email),
            ]);
        }

        // Save customer message
        $customerMessage = ChatMessage::create([
            'chat_conversation_id' => $conversation->id,
            'sender_type' => 'customer',
            'sender_id' => auth()->check() ? auth()->id() : null,
            'message' => $request->message,
        ]);

        $adminEmails = User::where('is_admin', true)
            ->pluck('email')
            ->filter()
            ->unique()
            ->toArray();

        if (empty($adminEmails)) {
            $adminEmails = [config('mail.from.address')];
        }

        try {
            Mail::to($adminEmails)->send(new \App\Mail\ChatMessageNotificationMail(
                $customerMessage,
                $conversation,
                $request->input('page_url'),
                $request->input('page_title')
            ));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::warning('Chat notification email failed: ' . $e->getMessage());
        }

        // Track chat question in visitor logs when available
        if ($request->session_id && $request->filled('message')) {
            \App\Models\VisitLog::where('chat_session_id', $request->session_id)
                ->orWhere(function ($query) use ($request) {
                    $query->whereNull('chat_session_id')
                          ->where('ip_address', request()->ip());
                })
                ->latest()
                ->limit(1)
                ->update(['chat_session_id' => $request->session_id, 'chat_question' => $request->message]);
        }

        $conversation->update(['last_activity' => now()]);

        try {
            broadcast(new MessageSent($customerMessage))->toOthers();
            broadcast(new ConversationUpdated($conversation))->toOthers();
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::warning('Broadcasting failed: ' . $e->getMessage());
        }

        // Check for handover triggers
        if ($conversation->ai_active && $aiService->shouldHandover($request->message)) {
            $conversation->update(['ai_active' => false, 'needs_admin' => true, 'status' => 'Waiting']);
            
            $handoverMsg = ChatMessage::create([
                'chat_conversation_id' => $conversation->id,
                'sender_type' => 'ai',
                'message' => "Let me give you a moment while I pull up that information for you. Please hold on.",
            ]);

            try {
                broadcast(new MessageSent($handoverMsg));
                broadcast(new ConversationUpdated($conversation));
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::warning('Broadcasting failed: ' . $e->getMessage());
            }
            
            return response()->json([
                'status' => 'handover',
                'message' => $handoverMsg
            ]);
        }

        // If AI is active, generate reply
        if ($conversation->ai_active) {
            $contextBuilder = app(AiContextBuilder::class);
            $websiteContext = $contextBuilder->buildWebsiteContext(
                $conversation,
                $request->input('page_url'),
                $request->input('page_title')
            );

            $aiReply = $aiService->generateReply($conversation, $request->message, $websiteContext);
            
            $aiMessage = ChatMessage::create([
                'chat_conversation_id' => $conversation->id,
                'sender_type' => 'ai',
                'message' => $aiReply,
            ]);

            try {
                broadcast(new MessageSent($aiMessage));
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::warning('Broadcasting failed: ' . $e->getMessage());
            }

            return response()->json([
                'status' => 'replied',
                'message' => $aiMessage
            ]);
        } else {
            $conversation->update(['needs_admin' => true, 'status' => 'Waiting']);
            try {
                broadcast(new ConversationUpdated($conversation));
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::warning('Broadcasting failed: ' . $e->getMessage());
            }
            
            return response()->json([
                'status' => 'waiting'
            ]);
        }
    }
}
