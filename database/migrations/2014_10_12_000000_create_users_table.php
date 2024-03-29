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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->integer('balance')->default(0);
            $table->integer('totalSpent')->default(0);
            $table->integer('totalSold')->default(0);
            $table->integer('totalProfit')->default(0);
            $table->integer('inventoryWorth')->default(0);
            $table->integer('inventoryNumber')->default(0);
            $table->integer('transactionNumber')->default(0);
           
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->tinyInteger("role_id")->default(1);
           

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
