<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(Positions::class);
        $this->call(Users::class);
        $this->call(Parameters::class);
        $this->call(PasswordResets::class);
    }
}


