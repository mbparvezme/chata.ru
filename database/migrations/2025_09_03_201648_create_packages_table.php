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
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // e.g., "Free", "Premium"
            $table->integer('daily_sessions')->nullable(); // NULL means unlimited
            $table->integer('responses_per_session')->nullable(); // NULL means unlimited
            $table->boolean('is_default')->default(false); // Marks the free package
            $table->timestamps();

            $table->index(['name']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};
