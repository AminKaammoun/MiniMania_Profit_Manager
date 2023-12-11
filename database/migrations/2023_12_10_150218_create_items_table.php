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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string("nameEn")->nullable();
            $table->string("namePt")->nullable();
            $table->unsignedBigInteger("typeId")->nullable();
            $table->unsignedBigInteger("categoryId")->nullable();
            $table->foreign('typeId')->references('id')->on('types')->onDelete('restrict');
            $table->foreign('categoryId')->references('id')->on('categories')->onDelete('restrict');
            $table->string("image")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
