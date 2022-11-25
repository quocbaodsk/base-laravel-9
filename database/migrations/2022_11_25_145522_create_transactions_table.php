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
        Schema::create('transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code');
            $table->string('prefix');
            $table->float('amount', 11);
            $table->string('type');
            $table->string('descr')->nullable();
            $table->string('sys_note')->nullable();
            $table->longText('extras')->nullable();
            $table->integer('balanceBefore');
            $table->integer('balanceAfter');
            $table->string('status')->default('success');
            $table->integer('user_id');
            $table->string('username');
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
        Schema::dropIfExists('transactions');
    }
};
