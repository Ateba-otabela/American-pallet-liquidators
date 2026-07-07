<?php

namespace App\Http\Controllers;

use App\Models\ChatConversation;
use App\Models\ChatMessage;
use App\Events\MessageSent;
use App\Events\ConversationUpdated;
use App\Services\OpenRouterService;
use Illuminate\Http\Request;
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

    public function sendMessage(Request $request, OpenRouterService $gemini)
    {
        $request->validate([
            'session_id' => 'required|string',
            'message' => 'required|string',
        ]);

        $conversation = ChatConversation::where('session_id', $request->session_id)->firstOrFail();
        
        // Save customer message
        $customerMessage = ChatMessage::create([
            'chat_conversation_id' => $conversation->id,
            'sender_type' => 'customer',
            'sender_id' => auth()->check() ? auth()->id() : null,
            'message' => $request->message,
        ]);

        $conversation->update(['last_activity' => now()]);

        broadcast(new MessageSent($customerMessage))->toOthers();
        broadcast(new ConversationUpdated($conversation))->toOthers();

        // Check for handover triggers
        if ($conversation->ai_active && $gemini->shouldHandover($request->message)) {
            $conversation->update(['ai_active' => false, 'needs_admin' => true, 'status' => 'Waiting']);
            
            $handoverMsg = ChatMessage::create([
                'chat_conversation_id' => $conversation->id,
                'sender_type' => 'ai',
                'message' => "Let me give you a moment while I pull up that information for you. Please hold on.",
            ]);
            broadcast(new MessageSent($handoverMsg));
            broadcast(new ConversationUpdated($conversation));
            
            return response()->json(['status' => 'handover']);
        }

        // If AI is active, generate reply
        if ($conversation->ai_active) {
            $aiReply = $gemini->generateReply($conversation, $request->message);
            
            $aiMessage = ChatMessage::create([
                'chat_conversation_id' => $conversation->id,
                'sender_type' => 'ai',
                'message' => $aiReply,
            ]);

            broadcast(new MessageSent($aiMessage));
        } else {
            $conversation->update(['needs_admin' => true, 'status' => 'Waiting']);
            broadcast(new ConversationUpdated($conversation));
        }

        return response()->json(['status' => 'sent']);
    }
}
