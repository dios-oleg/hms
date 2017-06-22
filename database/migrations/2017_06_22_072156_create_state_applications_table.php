<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStateApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('status_holidays', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('holiday_id');
            $table->integer('head_id'); // user_id
            $table->boolean('holiday_status')->default(true);
            $table->timestamps(); // TODO только дата создания
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('state_applications');
    }
}
