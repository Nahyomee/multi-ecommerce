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
        Schema::create('paystack_settings', function (Blueprint $table) {
            $table->id();
            $table->string('currency');
            $table->decimal('rate');
            $table->string('public_key');
            $table->string('secret_key');
            $table->string('merchant_email')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paystack_settings');
    }
};
