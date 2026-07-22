<?php

namespace App\Mail;

use App\Models\ChatConversation;
use App\Models\ChatMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ChatMessageNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public ChatMessage $chatMessage;
    public ChatConversation $conversation;
    public ?string $pageUrl;
    public ?string $pageTitle;

    public function __construct(ChatMessage $chatMessage, ChatConversation $conversation, ?string $pageUrl, ?string $pageTitle)
    {
        $this->chatMessage = $chatMessage;
        $this->conversation = $conversation;
        $this->pageUrl = $pageUrl;
        $this->pageTitle = $pageTitle;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Chat Message from ' . ($this->conversation->customer_name ?: 'Guest'),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.chat_message_notification',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
