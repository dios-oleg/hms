<?php

use Illuminate\Database\Seeder;

class PasswordResets extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('password_resets')->truncate();
    }
}
