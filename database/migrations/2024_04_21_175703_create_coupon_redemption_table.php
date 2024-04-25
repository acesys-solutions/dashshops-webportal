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
        Schema::create('coupon_redemption', function (Blueprint $table) {
            $table->id();
            $table->integer('coupon_id');
            $table->integer('user_id');
            $table->integer('coupon_download_id');
            $table->string('redemption_code');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupon_redemption');
    }
};
