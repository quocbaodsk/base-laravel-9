<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username')->unique();
            $table->string('password');
            $table->string('email')->unique();
            $table->string('phone_no')->nullable()->unique();
            $table->string('full_name')->nullable();
            $table->integer('balance')->default(0);
            $table->integer('total_deposit')->default(0);
            $table->string('roles')->default('user');
            $table->string('status')->default('active');
            $table->string('api_token')->nullable();
            $table->string('ip_address')->nullable();
            $table->dateTime('last_login')->nullable();
            $table->string('auth_ip')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
