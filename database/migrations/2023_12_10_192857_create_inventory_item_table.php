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
        Schema::create('inventory_item', function (Blueprint $table) {
            $table->unsignedBigInteger('inventoryId');
            $table->unsignedBigInteger("itemId");
            $table->primary(['inventoryId', 'itemId']);
            $table->foreign('inventoryId')->references('id')->on("inventories");
            $table->foreign("itemId")->references("id")->on("items");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_item');
    }
};
