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
        Schema::create('bills', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // References 'id' in the 'users' table

            // Correct and simplify the foreign key to reference the 'transactions' table
            $table->foreignId('transactions_id')->constrained('transactions')->onDelete('cascade');

            $table->string('name');
            $table->decimal('amount', 10, 2);
            $table->enum('frequency', ['daily', 'monthly', 'yearly']);
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bills');
    }
};
