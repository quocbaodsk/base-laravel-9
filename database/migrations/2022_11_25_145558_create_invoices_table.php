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
        Schema::create('invoices', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code');
            $table->string('prefix');
            $table->integer('amount');
            $table->string('type');
            $table->string('status');
            $table->string('channel');
            $table->integer('user_id');
            $table->string('username');
            $table->text('content')->nullable();
            $table->string('user_note')->nullable();
            $table->string('admin_note')->nullable();
            $table->dateTime('expired_at')->nullable();
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
        Schema::dropIfExists('invoices');
    }
};
