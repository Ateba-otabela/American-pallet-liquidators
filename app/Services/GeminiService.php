<?php

namespace App\Services;

use App\Models\ChatConversation;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeminiService
{
    protected $apiUrl = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent';
    
    public function __construct()
    {
        // Using a v1beta API URL format, defaulting to pro model.
        // We will pull the API key from config/env
    }

    public function generateReply(ChatConversation $conversation, string $newMessage)
    {
        $apiKey = env('GEMINI_API_KEY');
        if (!$apiKey) {
            Log::error('GEMINI_API_KEY is not set.');
            return "I'm sorry, I am currently experiencing technical difficulties. One of our support specialists will assist you shortly.";
        }

        // Build the prompt context
        $systemPrompt = "You are an experienced customer support representative for American Pallet Liquidators. " .
            "Your goal is to help customers exactly like a real employee would. " .
            "Never mention you are AI. Never mention Gemini. Never mention language models. " .
            "Reply naturally. Be concise. Be polite. Be confident. " .
            "If you don't know the answer, politely tell the customer you will have one of the support specialists continue assisting them. " .
            "Always try to keep customers satisfied. " .
            "If customers ask about pricing, products, shipping, pallets, returns, refunds, delivery or wholesale purchases, answer based on the company's available information. " .
            "If information isn't available, don't invent answers. " .
            "The customer's name is: " . ($conversation->customer_name ?? 'Guest') . ".";

        $history = [];
        foreach ($conversation->messages()->oldest()->get() as $msg) {
            // we don't send admin messages as user messages, but as model messages if they were sent by admin/ai
            $role = ($msg->sender_type === 'customer') ? 'user' : 'model';
            $history[] = [
                'role' => $role,
                'parts' => [['text' => $msg->message]]
            ];
        }

        // Add the new message to history
        $history[] = [
            'role' => 'user',
            'parts' => [['text' => $newMessage]]
        ];

        // Ensure alternating roles if strictly required by Gemini, or simply pass contents
        // Gemini API structure for contents:
        $payload = [
            'system_instruction' => [
                'parts' => [['text' => $systemPrompt]]
            ],
            'contents' => $history,
            'generationConfig' => [
                'temperature' => 0.4,
                'maxOutputTokens' => 500,
            ]
        ];

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post($this->apiUrl . '?key=' . $apiKey, $payload);

            if ($response->successful()) {
                $data = $response->json();
                if (isset($data['candidates'][0]['content']['parts'][0]['text'])) {
                    return $data['candidates'][0]['content']['parts'][0]['text'];
                }
            }
            
            Log::error('Gemini API Error: ' . $response->body());
        } catch (\Exception $e) {
            Log::error('Gemini Service Exception: ' . $e->getMessage());
        }

        return "I'm sorry, let me confirm that for you. One of our support specialists will continue assisting you shortly.";
    }

    public function shouldHandover(string $message): bool
    {
        $triggers = [
            'speak to someone', 'talk to an agent', 'i need a human',
            'manager', 'supervisor', 'complaint', 'human', 'representative'
        ];

        $lowerMessage = strtolower($message);
        foreach ($triggers as $trigger) {
            if (str_contains($lowerMessage, $trigger)) {
                return true;
            }
        }

        return false;
    }
}
