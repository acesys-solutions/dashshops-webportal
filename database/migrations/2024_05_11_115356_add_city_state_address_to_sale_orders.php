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
        Schema::table('sale_orders', function (Blueprint $table) {
            //
            $table->string('address')->after('proposed_route');
            $table->string('city')->after('address');
            $table->string('state')->after('city');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sale_orders', function (Blueprint $table) {
            //
            $table->dropColumn('state');
            $table->dropColumn(
                'city'
            );
            $table->dropColumn('address');
        });
    }
};
