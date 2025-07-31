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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('customer_id')->unique();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('citizenship', 2)->nullable();
            $table->string('email_address')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('address1')->nullable();
            $table->string('address2')->nullable();
            $table->string('address_city')->nullable();
            $table->string('address_state_region')->nullable();
            $table->string('address_postal_code')->nullable();
            $table->string('address_country_code', 2)->nullable();
            $table->decimal('identity_accuracy_score', 8, 4)->nullable();
            $table->decimal('fraud_score', 8, 4)->nullable();
            $table->timestamps();

            $table->index(['user_id']);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
