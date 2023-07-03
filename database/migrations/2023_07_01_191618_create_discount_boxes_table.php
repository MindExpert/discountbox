<?php

use App\Enums\StatusEnum;
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
        Schema::create('discount_boxes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('coupon_id')->nullable();
            $table->string('serial')->index()->unique();
            $table->string('name')->index();
            $table->unsignedInteger('price')->default(0);
            $table->unsignedInteger('discount')->default(0);
            $table->unsignedInteger('total')->default(0);
            $table->timestamp('expires_at')->nullable();
            $table->unsignedInteger('credits');
            $table->string('status')->default(StatusEnum::default()->value);
            $table->boolean('highlighted')->default(false);
            $table->boolean('show_on_home')->default(false);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('coupon_id')->references('id')->on('coupons');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discount_boxes');
    }
};
