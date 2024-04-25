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
        Schema::create('sales_retailers', function (Blueprint $table) {
            $table->id();
            $table->integer('sales_user_id');
            $table->integer('retailer_id');
            $table->timestamps();

            $table->foreign('sales_user_id')->references('id')->on('users');
            $table->foreign('retailer_id')->references('id')->on('retailers');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_retailers');
    }
};
