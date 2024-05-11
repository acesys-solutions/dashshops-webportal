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
        Schema::create('driver_settings', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->tinyInteger('push_notification')->default(1);
            $table->tinyInteger('location')->default(1);
            $table->tinyInteger('disable_caching')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('driver_settings');
    }
};
