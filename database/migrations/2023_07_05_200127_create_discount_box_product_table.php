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
        Schema::create('discount_box_product', function (Blueprint $table) {
            $table->id();
            $table->foreignId('discount_box_id');
            $table->foreignId('product_id');
            $table->timestamps();

            $table->foreign('discount_box_id')->references('id')->on('discount_boxes')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');

            $table->unique(['discount_box_id', 'product_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discount_box_product');
    }
};
