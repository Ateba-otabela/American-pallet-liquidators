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
        Schema::table('visit_logs', function (Blueprint $table) {
            $table->string('chat_session_id', 100)->nullable()->after('location');
            $table->text('chat_question')->nullable()->after('chat_session_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('visit_logs', function (Blueprint $table) {
            $table->dropColumn(['chat_session_id', 'chat_question']);
        });
    }
};
