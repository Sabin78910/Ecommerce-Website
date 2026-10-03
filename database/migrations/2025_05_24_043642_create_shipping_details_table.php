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
        Schema::create('shipping_details', function (Blueprint $table) {
            $table->id();

            // Link back to orders.id:
            $table->foreignId('order_id')
                ->constrained('orders')
                ->cascadeOnDelete();



            // Courier & tracking
            $table->string('courier_name')->nullable();
            $table->string('tracking_id')->nullable();
            $table->string('tracking_url')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipping_details');
    }
};
