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
    'customer_name' => 'Test Customer',
    'status' => 'Open', 'ai_active' => true, 'needs_admin' => false, 'last_activity' => now(),
]);

$service = new OpenRouterService();
$questions = ['Do you accept PayPal?', 'Can I pick up from the warehouse?', 'What is your return policy?'];
foreach ($questions as $q) {
    echo "Q: $q\nA: " . $service->generateReply($conv, $q) . "\n\n";
}
$conv->delete();
