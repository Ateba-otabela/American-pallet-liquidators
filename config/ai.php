<?php

return [
    'provider' => env('AI_PROVIDER', 'gemini'),

    'providers' => [
        'openrouter' => [
            'api_key' => env('OPENROUTER_API_KEY'),
            'model' => env('OPENROUTER_MODEL', 'google/gemma-4-26b-a4b-it:free'),
            'max_tokens' => 500,
            'temperature' => 0.4,
        ],
        'gemini' => [
            'api_key' => env('GEMINI_API_KEY'),
            'model' => env('GEMINI_MODEL', 'gemini-2.0-flash-lite'), // 1500 req/day free vs 20/day for 2.5-flash
            'max_tokens' => 500,
            'temperature' => 0.4,
        ],
    ],
];
