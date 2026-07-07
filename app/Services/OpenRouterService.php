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
        $apiKey = config('ai.providers.openrouter.api_key');
        if (!$apiKey) {
            Log::error('OPENROUTER_API_KEY is not set.');
            return "I'm sorry, I am currently experiencing technical difficulties. One of our support specialists will assist you shortly.";
        }

        $model = config('ai.providers.openrouter.model', 'google/gemma-4-26b-a4b-it:free');

        $systemPrompt = "You are an experienced customer support representative for American Pallet Liquidators (APL). " .
            "Your goal is to help customers exactly like a real human employee would. " .
            "Keep your responses very concise and human-like (maximum 1-3 sentences). Never list points or write long paragraphs. " .
            "Never mention you are an AI, a language model, or associated with OpenRouter/Google/Gemini. " .
            "Be polite, confident, and direct. " .
            "Here is the company information you know: " .
            "1. Warehouse: Located in Louisville, Kentucky. Customers can inspect inventory and pick up in person. Forklift dock loading is free. " .
            "2. Shipping: We ship nationwide. Freight fees are not billed at checkout; they are calculated and billed separately after the order is placed, based on the delivery zip code and pallet/truckload size. " .
            "3. Payments: Stripe (for debit/credit), Chase bank wire, Zelle Business, Cash App, Venmo, PayPal, USDT crypto, and Cash on pickup. " .
            "4. Return Policy: All sales are strictly final. Everything is sold AS-IS / WHERE-IS. No returns, refunds, or exchanges. " .
            "5. Inventory Types: Liquidation pallets and retail store truckloads. Sourced from pharmacy chains, e-commerce networks, and department stores. " .
            "6. Shelf pulls are brand new overstock items. Customer returns are raw, unchecked, and may contain mixed new, open box, or damaged goods. " .
            "If customers ask for specific pricing of items, custom quotes, freight estimates, or details you do not know, politely tell them a support specialist will take over to assist them with those details. " .
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
            'max_tokens' => config('ai.providers.openrouter.max_tokens', 500),
            'temperature' => config('ai.providers.openrouter.temperature', 0.4),
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
