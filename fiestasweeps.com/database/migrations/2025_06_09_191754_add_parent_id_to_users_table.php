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
        Schema::table('users', function (Blueprint $table) {

            $table->unsignedBigInteger('parent_id')->nullable()->after('id');
            $table->foreign('parent_id')->references('id')->on('users')->onDelete('set null');
            $table->string('lname')->nullable()->after('parent_id');
            $table->string('phone')->nullable()->after('parent_id');
            $table->date('dob')->nullable()->after('parent_id');
            $table->tinyInteger('game_stats')->default(0)->after('parent_id');
            $table->tinyInteger('marketting_stats')->default(0)->after('parent_id');
            $table->tinyInteger('online_stats')->default(0)->after('parent_id');
            $table->tinyInteger('status')->default(1)->after('parent_id');
            //
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
