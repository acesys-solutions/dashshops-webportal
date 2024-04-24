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
        Schema::create('retailers', function (Blueprint $table) {
            $table->id();
            $table->string('business_name');
            $table->string('business_address');
            $table->string('business_description');
            $table->string('firstname');
            $table->string('lastname');
            $table->string('phone_number');
            $table->string('email');
            $table->integer('type_of_business');
            $table->string('business_hours_open');
            $table->string('business_hours_close');
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->integer('zip_code');
            $table->string('web_url')->nullable();
            $table->binary('banner_image')->nullable();
            $table->string('password');
            $table->double('longitude')->default(0);
            $table->double('latitude')->default(0);
            $table->string('island')->nullable();
            $table->string('approval_status')->default('New');
            $table->timestamp('approved_at')->nullable();
            $table->integer('from_mobile')->default(0);
            $table->integer('created_by');
            $table->integer('modified_by');
            $table->timestamps();

            $table->foreign('type_of_business')->references('id')->on('categories');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('modified_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('retailers');
    }
};
