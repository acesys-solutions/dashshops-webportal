<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('business_name');
            $table->string('business_address');
            $table->string('firstname');
            $table->string('lastname');
            $table->string('photo')->default('users/user.png');
            $table->string('city');
            $table->string('state');
            $table->string('zip_code');
            $table->string('email')->unique();
            $table->string('phone_number');
            $table->string('user_type')->default('Consumer');
            $table->tinyInteger('user_status')->default(0);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken()->nullable();
            $table->tinyInteger('admin')->default(0);
            $table->integer('is_vip')->default(0);
            $table->timestamp('approved_at')->nullable();
            $table->bigInteger('retailer_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
