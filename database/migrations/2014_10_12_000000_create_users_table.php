<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
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
            $table->string('first_name', '25');
            $table->string('last_name', '25');
            $table->string('last_name_print', '30');
            $table->string('patronymic', '25');
            $table->string('email')->unique();
            $table->string('address');
            $table->integer('head')->default(false);
            $table->integer('position_id');
            $table->string('password');
            $table->boolean('blocked')->default(false);
            $table->string('comment')->nullable();
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
}
