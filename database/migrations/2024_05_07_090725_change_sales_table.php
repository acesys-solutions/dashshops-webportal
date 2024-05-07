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
        Schema::table('sales', function (Blueprint $table) {
            $table->dropColumn('shipping_cost');
            $table->dropColumn('order_ref');
            $table->integer('order_id')->after('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->decimal('shipping_cost', 8, 2)->default(0);
            $table->string('order_ref')->nullable();
            $table->dropColumn('order_id');
        });
    }
};
