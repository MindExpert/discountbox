<?php

use App\Enums\DiscountRequestStatusEnum;
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
        Schema::create('discount_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('discount_box_id');
            $table->decimal('credit', 8, 2);
            $table->decimal('percentage', 8, 2);
            $table->enum('status', DiscountRequestStatusEnum::values())->default(DiscountRequestStatusEnum::default()->value);
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')
                ->references('id')
                ->on('users');

            $table->foreign('discount_box_id')
                ->references('id')
                ->on('discount_boxes');

            $table->unique(['user_id', 'discount_box_id'], 'user_id_discount_box_id_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discount_requests');
    }
};
