<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

if (!Schema::hasTable('subscribers')) {
    Schema::create('subscribers', function (Blueprint $table) {
        $table->id();
        $table->string('email')->unique();
        $table->timestamps();
    });
    echo "Subscribers table created.\n";
} else {
    echo "Subscribers table already exists.\n";
}

if (!Schema::hasTable('settings')) {
    Schema::create('settings', function (Blueprint $table) {
        $table->id();
        $table->string('key')->unique();
        $table->text('value')->nullable();
        $table->timestamps();
    });
    echo "Settings table created.\n";
} else {
    echo "Settings table already exists.\n";
}
