<?php

namespace App\Services;

use App\Models\ChatConversation;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class OpenRouterService
{
    protected $apiUrl = 'https://openrouter.ai/api/v1/chat/completions';

    public function generateReply(ChatConversation $conversation, string $newMessage): string
    {
        $apiKey = env('OPENROUTER_API_KEY');
        if (!$apiKey) {
            Log::error('OPENROUTER_API_KEY is not set.');
            return "I'm sorry, I am currently experiencing technical difficulties. One of our support specialists will assist you shortly.";
        }

        $model = env('OPENROUTER_MODEL', 'google/gemma-4-26b-a4b-it:free');

        $systemPrompt = "You are an experienced customer support representative for American Pallet Liquidators. " .
            "Your goal is to help customers exactly like a real employee would. " .
            "Never mention you are AI. Never mention any AI technology or language model. " .
            "Reply naturally. Be concise. Be polite. Be confident. " .
            "If you don't know the answer, politely tell the customer you will have one of the support specialists continue assisting them. " .
            "Always try to keep customers satisfied. " .
            "If customers ask about pricing, products, shipping, pallets, returns, refunds, delivery or wholesale purchases, answer based on the company's available information. " .
            "If information isn't available, don't invent answers. " .
            "The customer's name is: " . ($conversation->customer_name ?? 'Guest') . ".";

        // Build message history in OpenAI format
        $messages = [
            ['role' => 'system', 'content' => $systemPrompt],
        ];

        foreach ($conversation->messages()->oldest()->get() as $msg) {
            $role = ($msg->sender_type === 'customer') ? 'user' : 'assistant';
            $messages[] = [
                'role' => $role,
                'content' => $msg->message,
            ];
        }

        // Add the new incoming message
        $messages[] = [
            'role' => 'user',
            'content' => $newMessage,
        ];

        $payload = [
            'model' => $model,
            'messages' => $messages,
            'max_tokens' => 500,
            'temperature' => 0.4,
        ];

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $apiKey,
                'Content-Type'  => 'application/json',
                'HTTP-Referer'  => env('APP_URL', 'http://localhost'),
                'X-Title'       => 'American Pallet Liquidators',
            ])->timeout(60)->post($this->apiUrl, $payload);

            if ($response->successful()) {
                $data = $response->json();
                if (isset($data['choices'][0]['message']['content'])) {
                    return trim($data['choices'][0]['message']['content']);
                }
            }

            Log::error('OpenRouter API Error: ' . $response->body());
        } catch (\Exception $e) {
            Log::error('OpenRouter Service Exception: ' . $e->getMessage());
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
