<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Enum\TypesParameters;

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
            $table->string('key')->unique();
            $table->string('title');
            $table->string('value');
            //$table->enum(TypesParameters::getConstants())->default(TypesParameters::T_STRING);
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
        Schema::dropIfExists('system_parameters');
    }
}
