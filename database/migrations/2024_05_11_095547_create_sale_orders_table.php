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
        Schema::create('sale_orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number');
            $table->integer('user_id');
            $table->tinyInteger("is_store_pickup");
            $table->integer("driver_id")->nullable();
            $table->string('status');
            $table->double("service_charge")->default(0);
            $table->double("total_discount")->default(0);
            $table->double("total_cost")->default(0);
            $table->double('delivery_fee')->ddefault(0);
            $table->longText('proposed_route')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sale_orders');
    }
};
