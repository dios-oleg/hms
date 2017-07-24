<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Enum\StateHoliday;

class CreateStateHolidaysTable extends Migration
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
            $table->integer('holiday_id')->index();
            $table->integer('user_id')->index();
            $table->enum('new_status', StateHoliday::getConstants());
            $table->timestamp('created_at');
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
