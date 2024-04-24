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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->binary('image')->nullable();
            $table->string('name');
            $table->double('price', 8, 2);
            $table->integer('category_id')->unsigned();
            $table->integer('download_limit');
            $table->integer('retailer_id')->unsigned();
            $table->double('retail_price', 8, 2);
            $table->double('discount_now_price', 8, 2);
            $table->string('discount_percentage');
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->string('qr_code')->nullable();
            $table->string('discount_description')->nullable();
            $table->string('discount_code')->nullable();
            $table->string('offer_type');
            $table->string('approval_status')->default('New');
            $table->integer('created_by')->unsigned();
            $table->integer('modified_by')->unsigned();
            $table->timestamps();

            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('retailer_id')->references('id')->on('retailers')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('modified_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
