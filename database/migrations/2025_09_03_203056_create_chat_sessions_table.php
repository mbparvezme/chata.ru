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
        Schema::create('chat_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('ip_address'); // For tracking non-authenticated users
            $table->string('session_token')->unique(); // For guest sessions
            $table->json('chat_meta')->nullable(); // For guest sessions
            $table->integer('response_count')->default(0);
            $table->date('last_activity_date');
            $table->timestamps();

            $table->index(['user_id', 'last_activity_date']);
            $table->index(['ip_address', 'last_activity_date']);
            $table->index(['session_token']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chat_sessions');
    }
};
