<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Enum\Roles;

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
            //$roles = new App\Enum\Roles();
            $table->increments('id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('last_name_print');
            $table->string('patronymic');
            $table->string('email')->unique();
            $table->string('address');
            $table->enum('role', Roles::getConstants())->default(Roles::EMPLOYEE);
            $table->integer('position_id')->index();
            $table->string('password');
            $table->boolean('is_blocked')->default(false);
            $table->string('comment')->nullable()->default(null);
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
