<?php

use App\Enums\ProductDiscountRequestStatusEnum;
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
        Schema::create('product_discount_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('discount_box_id');
            $table->foreignId('product_id');
            $table->decimal('credit', 8, 2);
            $table->enum('status', ProductDiscountRequestStatusEnum::values())->default(ProductDiscountRequestStatusEnum::default()->value);
            $table->text('notes')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')
                ->references('id')
                ->on('users');

            $table->foreign('discount_box_id')
                ->references('id')
                ->on('discount_boxes');

            $table->foreign('product_id')
                ->references('id')
                ->on('products');

            $table->unique(['user_id', 'discount_box_id', 'product_id'], 'user_id_discount_box_id_product_id_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_discount_requests');
    }
};
