<?php

use Illuminate\Database\Seeder;
use App\Models\Position;

class Positions extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Position::truncate();

        Position::create([
            'name' => 'Директор',
            'name_print' => 'Директора',
        ]);

        Position::create([
            'name' => 'Начальник',
            'name_print' => 'Начальника',
        ]);

        Position::create([
            'name' => 'Инженер',
            'name_print' => 'Инженера',
        ]);

        Position::create([
            'name' => 'Инженер-программист',
            'name_print' => 'Инженера-программиста',
        ]);

        Position::create([
            'name' => 'Техник-программист',
            'name_print' => 'Техника-программиста',
        ]);

        Position::create([
            'name' => 'Системный программист',
            'name_print' => 'Системного программиста',
        ]);
    }
}
