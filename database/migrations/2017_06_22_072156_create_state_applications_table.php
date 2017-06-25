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
            $table->integer('head_id')->comment('user_id from users');
            $table->boolean('holiday_status')->default(true);
            $table->timestamp('created_at');
            
            //$table->foreign('holiday_id')->references('id')->on('holidays')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('status_holidays');
    }
}
