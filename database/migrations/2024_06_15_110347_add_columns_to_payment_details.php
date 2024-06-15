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
        Schema::table('payment_details', function (Blueprint $table) {
            //
            $table->string('fullname')->after('is_default')->nullable();
            $table->string('email')->after('fullname')->nullable();
            $table->string('phone')->after('email')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payment_details', function (Blueprint $table) {
            //
            $table->dropColumn('phone');
            $table->dropColumn('email');
            $table->dropColumn('fullname');
        });
    }
};
