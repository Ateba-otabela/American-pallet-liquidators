<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('visit_logs', function (Blueprint $table) {
            $table->id();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->string('device_type', 50)->nullable(); // Mobile, Tablet, Desktop
            $table->string('os', 100)->nullable(); // Operating System (iOS, Android, Windows...)
            $table->string('browser', 100)->nullable(); // Browser Name
            $table->string('path', 255)->nullable(); // Path Visited
            $table->string('location', 255)->nullable(); // Location resolved
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visit_logs');
    }
};
