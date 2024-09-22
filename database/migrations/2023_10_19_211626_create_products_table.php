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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vendor_id')->constrained('vendors');
            $table->foreignId('category_id')->constrained('categories');
            $table->foreignId('subcategory_id')->nullable()->constrained('sub_categories');
            $table->foreignId('child_category_id')->nullable()->constrained('child_categories');
            $table->foreignId('brand_id')->constrained('brands');
            $table->string('name');
            $table->string('slug');
            $table->string('thumb_img')->nullable();
            $table->integer('quantity');
            $table->decimal('price');
            $table->text('short_desc');
            $table->text('description');
            $table->text('video_link')->nullable();
            $table->string('sku')->nullable();
            $table->string('offer_price')->nullable();
            $table->date('offer_start')->nullable();
            $table->date('offer_end')->nullable();
            $table->string('product_type')->nullable();
            $table->integer('is_approved')->default(0);
            $table->boolean('status');
            $table->string('seo_title')->nullable();
            $table->string('seo_description')->nullable();
            $table->timestamps();
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
