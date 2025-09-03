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
        Schema::create('daily_limits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained();
            $table->string('ip_address')->nullable();
            $table->date('date');
            $table->integer('sessions_count')->default(0);
            $table->integer('responses_count')->default(0);
            $table->timestamps();

            $table->unique(['user_id', 'date']);
            $table->unique(['ip_address', 'date']);
            $table->index('date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_limits');
    }
};
