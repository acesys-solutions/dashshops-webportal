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
        Schema::table('rejected_deliveries', function (Blueprint $table) {
            //
            $table->double("delivery_fee")->after('sales_id')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rejected_deliveries', function (Blueprint $table) {
            //
            $table->dropColumn("delivery_fee");
        });
    }
};
