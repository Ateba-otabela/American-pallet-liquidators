<?php

namespace App\Http\Controllers;

use App\Models\ChatConversation;
use App\Models\ChatMessage;
use App\Events\MessageSent;
use App\Events\ConversationUpdated;
use Illuminate\Http\Request;

class AdminSupportController extends Controller
{
    public function index()
    {
        $conversations = ChatConversation::with(['messages' => function($q) {
            $q->latest()->limit(1);
        }])->orderBy('last_activity', 'desc')->paginate(20);
        
        return view('admin.support.index', compact('conversations'));
    }

    public function show(ChatConversation $conversation)
    {
        // When admin opens, mark AI as inactive if they want to take over? 
        // We'll let them click a 'Take Over' button to be explicit, but opening marks messages as seen.
        $conversation->messages()->where('sender_type', 'customer')->update(['is_seen' => true]);
        
        return view('admin.support.show', compact('conversation'));
    }

    public function takeOver(ChatConversation $conversation)
    {
        $conversation->update([
            'ai_active' => false,
            'needs_admin' => false,
            'assigned_admin_id' => auth()->id(),
            'status' => 'Open'
        ]);

        broadcast(new ConversationUpdated($conversation));

        return back()->with('success', 'You have taken over the conversation.');
    }

    public function resumeAi(ChatConversation $conversation)
    {
        $conversation->update([
            'ai_active' => true,
            'assigned_admin_id' => null,
            'status' => 'Open'
        ]);

        broadcast(new ConversationUpdated($conversation));

        return back()->with('success', 'AI has resumed the conversation.');
    }

    public function reply(Request $request, ChatConversation $conversation)
    {
        $request->validate(['message' => 'required|string']);

        $message = ChatMessage::create([
            'chat_conversation_id' => $conversation->id,
            'sender_type' => 'admin',
            'sender_id' => auth()->id(),
            'message' => $request->message,
        ]);

        $conversation->update(['last_activity' => now(), 'status' => 'Waiting']);

        broadcast(new MessageSent($message))->toOthers();
        broadcast(new ConversationUpdated($conversation));

        return back();
    }
}
