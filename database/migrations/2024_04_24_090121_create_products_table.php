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
            $table->text('product_name');
            $table->string('alias', 250)->nullable();
            $table->text('image')->nullable();
            $table->longtext('images')->nullable();
            $table->integer('store_id');
            $table->longtext('description')->nullable();
            $table->text('overview')->nullable();
            $table->text('tags')->nullable();
            $table->string('waranty')->nullable();
            $table->integer('status')->default(-1);
            $table->integer('category_id');
            $table->timestamps();

            $table->foreign('store_id')->references('id')->on('retailers')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
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
