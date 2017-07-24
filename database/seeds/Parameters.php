<?php

use Illuminate\Database\Seeder;
use App\Models\SystemParameter;

class Parameters extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SystemParameter::truncate();

        SystemParameter::create([
           'key' => 'name',
           'title' => 'Наименование огранизации',
           'value' => 'ООО "Дженерал Софт"',
        ]);

        SystemParameter::create([
           'key' => 'boss',
           'title' => 'Директор',
           'value' => 'Пальчик А.В.',
        ]);

        SystemParameter::create([
           'key' => 'boss_print',
           'title' => 'Директор в д.п.',
           'value' => 'Пальчику А.В.',
        ]);

        SystemParameter::create([
           'key' => 'min_holiday_days',
           'title' => 'Минимальное количество дней отпуска в год',
           'value' => '1',
        ]);

        SystemParameter::create([
           'key' => 'max_holiday_days',
           'title' => 'Максимальная длительность отпуска в год',
           'value' => '24',
        ]);

    }
}
