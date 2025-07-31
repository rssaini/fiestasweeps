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
        Schema::create('session_responses', function (Blueprint $table) {
            $table->id();

            $table->uuid('session_id');
            $table->string('service_type');
            $table->string('customer_id');
            $table->text('reason_codes')->nullable();
            $table->longText('session_response_raw')->nullable();
            $table->timestamps();

            $table->foreign('session_id')->references('session_id')->on('sessions_requests')->onDelete('cascade');
            $table->foreign('customer_id')->references('customer_id')->on('customers')->onDelete('cascade');

            $table->index(['session_id']);
            $table->index(['customer_id']);
            $table->index(['service_type']);


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('session_responses');
    }
};
