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
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->uuid('session_id')->nullable();
            $table->string('customer_id')->nullable();
            $table->text('location_detail')->nullable();
            $table->timestamps();

            $table->foreign('session_id')->references('session_id')->on('sessions_requests')->onDelete('set null');
            $table->foreign('customer_id')->references('customer_id')->on('customers')->onDelete('set null');

            $table->index(['session_id']);
            $table->index(['customer_id']);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('locations');
    }
};
