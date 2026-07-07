<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\ChatConversation;
use App\Models\ChatMessage;
use App\Services\GeminiService;
use Illuminate\Support\Str;

$conv = ChatConversation::create([
    'session_id' => Str::uuid()->toString(),
    'user_id' => null,
    'customer_name' => 'Guest',
    'customer_email' => null,
    'status' => 'Open',
    'ai_active' => true,
    'needs_admin' => false,
    'last_activity' => now(),
]);

$gemini = new GeminiService();
echo "Testing Gemini...\n";
$response = $gemini->generateReply($conv, "Hello, do you have any electronics pallets?");
echo "Response: " . $response . "\n";

// Clean up
$conv->delete();

