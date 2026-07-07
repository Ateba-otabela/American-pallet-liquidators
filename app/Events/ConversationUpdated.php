<?php

namespace App\Events;

use App\Models\ChatConversation;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ConversationUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $conversation;

    public function __construct(ChatConversation $conversation)
    {
        $this->conversation = $conversation;
    }

    public function broadcastOn(): array
    {
        return [
            new Channel('chat.' . $this->conversation->session_id),
            new PrivateChannel('admin.support'),
        ];
    }

    public function broadcastWith(): array
    {
        return [
            'conversation' => $this->conversation,
        ];
    }
}
