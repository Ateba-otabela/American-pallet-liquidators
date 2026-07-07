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
        $apiKey = config('ai.providers.gemini.api_key');
        if (!$apiKey) {
            Log::error('GEMINI_API_KEY is not set.');
            return "I'm sorry, I am currently experiencing technical difficulties. One of our support specialists will assist you shortly.";
        }

        $model = config('ai.providers.gemini.model', 'gemini-2.5-flash');
        $url = "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent";

        // Build the prompt context
        $systemPrompt = "You are an experienced customer support representative for American Pallet Liquidators (APL). " .
            "Your goal is to help customers exactly like a real human employee would. " .
            "Keep your responses very concise and human-like (maximum 1-3 sentences). Never list points or write long paragraphs. " .
            "Never mention you are an AI, a language model, or associated with Google/Gemini/OpenRouter. " .
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

        $payload = [
            'system_instruction' => [
                'parts' => [['text' => $systemPrompt]]
            ],
            'contents' => $history,
            'generationConfig' => [
                'temperature' => config('ai.providers.gemini.temperature', 0.4),
                'maxOutputTokens' => config('ai.providers.gemini.max_tokens', 500),
            ]
        ];

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post($url . '?key=' . $apiKey, $payload);

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
