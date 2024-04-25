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
        Schema::create('product_variation', function (Blueprint $table) {
            $table->id();
            $table->integer('product_id');
            $table->string('variant_types', 60)->nullable();
            $table->string('variant_type_values', 80)->nullable();
            $table->double('price');
            $table->tinyInteger('on_sale')->default(0);
            $table->double('sale_price')->default(0);
            $table->integer('quantity');
            $table->integer('low_stock_value')->default(1);
            $table->string('sku', 50)->nullable();
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_variation');
    }
};
