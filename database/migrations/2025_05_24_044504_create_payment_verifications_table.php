<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payment_verifications', function (Blueprint $table) {
            $table->id();

            // 1. order_id FK
            $table->foreignId('order_id')
                ->constrained('orders')
                ->cascadeOnDelete();

            // 2. file name of the proof (you’ll store just the filename or path)
            $table->string('proof_of_payment');

            // 3. currency code (e.g. "USD", "NPR")
            $table->string('currency', 13);

            // 4. amount in that currency
            $table->decimal('amount', 12, 2);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_verifications');
    }
};
