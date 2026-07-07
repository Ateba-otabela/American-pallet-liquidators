<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\ChatConversation;
use App\Services\OpenRouterService;
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

$service = new OpenRouterService();
echo "Testing OpenRouter AI...\n";
$response = $service->generateReply($conv, "Hello! Do you have any electronics pallets available?");
echo "AI Response: " . $response . "\n";

// Clean up test conversation
$conv->delete();
