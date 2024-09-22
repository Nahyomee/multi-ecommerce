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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_id');
            $table->foreignId('user_id')->constrained('users');
            $table->decimal('sub_total');
            $table->decimal('amount');
            $table->integer('qty');
            $table->string('currency');
            $table->string('currency_icon');
            $table->string('payment_method');
            $table->string('payment_status');
            $table->text('coupon');
            $table->string('shipping_method');
            $table->text('shipping_address');
            $table->string('status')->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
