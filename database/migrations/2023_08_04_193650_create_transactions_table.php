<?php

use App\Enums\TransactionTypeEnum;
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
            $table->foreignId('user_id');
            $table->nullableMorphs('transactional');
            $table->string('name');
            $table->text('notes')->nullable();
            $table->unsignedDecimal('credit', 8, 2)->default(0)->comment('+');
            $table->unsignedDecimal('debit', 8, 2)->default(0)->comment('-');
            $table->enum('type', TransactionTypeEnum::values())->default(TransactionTypeEnum::default()->value);
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
        Schema::dropIfExists('transactions');
    }
};
