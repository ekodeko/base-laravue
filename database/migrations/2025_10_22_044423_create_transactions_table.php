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
            $table->uuid('id')->primary();
            $table->date('date');
            $table->string('number')->unique();
            $table->string('type'); // income/expense
            $table->text('description')->nullable();
            $table->decimal('amount', 15, 2);
            $table->foreignUuid('account_id')->constrained('accounts');
            $table->foreignUuid('category_id')->constrained('categories');
            $table->foreignUuid('contact_id')->constrained('contacts');
            $table->timestamps();
            $table->softDeletes();
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
