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
        Schema::create('session_requests', function (Blueprint $table) {
            $table->id();
            $table->uuid('session_id')->nullable();
            $table->string('service_type');
            $table->string('customer_id');
            $table->string('device_location')->nullable();
            $table->longText('session_request_raw')->nullable();
            $table->timestamps();
            $table->index(['customer_id']);
            $table->index(['service_type']);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('session_requests');
    }
};
