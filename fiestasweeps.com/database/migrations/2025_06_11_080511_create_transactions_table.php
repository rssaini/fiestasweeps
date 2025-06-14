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
        Schema::create('transactions', function (Blueprint $table) {
        $table->id();
        $table->string('player_id');
        $table->foreignId('game_id')->nullable()->constrained()->onDelete('set null');
        $table->decimal('amount', 10, 2);
        $table->decimal('points', 10, 2);

        $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
        $table->foreignId('updated_by')->constrained('users')->onDelete('cascade')->nullable()->default(null);

        $table->decimal('last_deposit', 10, 2)->nullable()->default(null);
        $table->foreignId('deposit_handle_id')->constrained('payment_handles')->nullable()->default(null);

        $table->foreignId('handle_id')->constrained('payment_handles')->nullable();
        $table->string('player_handle')->nullable(); // handle for the player, if applicable

        $table->enum('status', ['pending', 'completed', 'failed', 'review'])->default('pending');
        $table->string('transaction_type')->comment('deposit, withdrawal, etc.');

        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
