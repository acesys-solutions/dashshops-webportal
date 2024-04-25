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
