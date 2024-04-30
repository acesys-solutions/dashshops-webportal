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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->integer(
                'user_id'
            );
            $table->string('order_ref', 191);
            $table->integer(
                'product_variation_id'
            );
            $table->integer(
                'retailer_id'
            );
            $table->string('business_name', 191);
            $table->string('product_name', 191);
            $table->string('product_image', 191);
            $table->integer(
                'quantity'
            );
            $table->double('unit_cost');
            $table->string('address', 191)->nullable();
            $table->string(
                'city',
                191
            );
            $table->string(
                'state',
                191
            );
            $table->string(
                'variation_name',
                191
            );
            $table->string(
                'status',
                191
            );
            $table->double(
                'shipping_cost'
            );
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
