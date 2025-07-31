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
        Schema::create('customer_monitors', function (Blueprint $table) {
            $table->id();
            $table->uuid('session_id')->nullable();
            $table->string('customer_id');
            $table->text('reason_codes')->nullable();
            $table->text('watch_checks')->nullable();
            $table->text('location_detail')->nullable();
            $table->decimal('identity_confidence_score', 8, 4)->nullable();
            $table->decimal('fraud_confidence_score', 8, 4)->nullable();
            $table->timestamps();

            $table->foreign('session_id')->references('session_id')->on('sessions_requests')->onDelete('set null');
            $table->foreign('customer_id')->references('customer_id')->on('customers')->onDelete('cascade');

            $table->index(['customer_id']);
            $table->index(['session_id']);


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_monitors');
    }
};
