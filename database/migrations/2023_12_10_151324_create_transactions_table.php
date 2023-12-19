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
            $table->unsignedBigInteger("itemId");
            $table->unsignedBigInteger("userId");
            $table->foreign('itemId')->references('id')->on('items')->onDelete('restrict');
            $table->foreign('userId')->references('id')->on('users')->onDelete('restrict');
            $table->integer("boughtPrice");
            $table->integer("SoldPrice")->nullable();
            $table->date("boughtDate")->nullable();
            $table->date("soldDate")->nullable();
            $table->integer("profit")->nullable();
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
