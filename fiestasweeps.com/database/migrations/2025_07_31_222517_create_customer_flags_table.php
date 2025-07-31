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
        Schema::create('customer_flags', function (Blueprint $table) {
            $table->id();
            $table->string('flag');
            $table->string('customer_id');
            $table->timestamps();
            $table->foreign('customer_id')->references('customer_id')->on('customers')->onDelete('cascade');

            $table->index(['customer_id']);
            $table->index(['flag']);
            $table->unique(['customer_id', 'flag']);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_flags');
    }
};
