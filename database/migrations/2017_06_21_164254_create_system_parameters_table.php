<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSystemParametersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('system_parameters', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name_organization');
            $table->string('fullname_director');
            $table->integer('min_leave');
            $table->integer('max_leave');
            $table->date('valid_until')->nullable(); 
            $table->timestamps(); // TODO только создания, используется последняя
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('system_parameters');
    }
}
