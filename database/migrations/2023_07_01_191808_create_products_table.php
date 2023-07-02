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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable();
            $table->string('serial')->index()->unique();
            $table->string('name')->index();
            $table->text('description')->nullable();
            $table->text('review')->nullable();
            $table->text('url')->nullable();
            $table->string('status')->default(StatusEnum::default()->value);
            $table->boolean('highlighted')->default(false);
            $table->boolean('show_on_home')->default(false);
            $table->timestamp('concluded_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
