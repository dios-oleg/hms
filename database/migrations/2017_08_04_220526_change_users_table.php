<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeUsersTable extends Migration
{
    public function __construct()
    {
        DB::getDoctrineSchemaManager()->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');
    }
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('first_name')->nullable()->default(null)->change();
            $table->string('last_name')->nullable()->default(null)->change();
            $table->string('last_name_print')->nullable()->default(null)->change();
            $table->string('patronymic')->nullable()->default(null)->change();
            $table->string('address')->nullable()->default(null)->change();
            $table->string('password')->nullable()->default(null)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('first_name')->change();
            $table->string('last_name')->change();
            $table->string('last_name_print')->change();
            $table->string('patronymic')->change();
            $table->string('address')->change();
            $table->string('password')->change();
        });
    }
}
