<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/
use App\Enum\Roles;
use App\Models\Position;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\User::class, function (Faker\Generator $faker) {
    static $password; // TODO а нужен ли?

    $faker = Faker\Factory::create('ru_RU');

    // WARN в новой версии будет другой метод для отчества
    // определяем пол и фамилии
    $gender = rand(0, 1) >= 0.6;
    $lastName = $faker->lastName;
    $lastNamePrint = $lastName;

    // уволен
    $dismissed = rand(0, 10) == 10;

    return [
        'first_name' => $gender ? $faker->firstNameMale : $faker->firstNameFemale,
        'last_name' => $gender ? $lastName : $lastName.'а',
        'last_name_print' => $gender ? $lastNamePrint.'a' : $lastNamePrint.'ой',
        'patronymic' => $gender ? $faker->middleNameMale : $faker->middleNameFemale,
        'email' => $faker->unique()->safeEmail,
        'address' => $faker->address.', '.$faker->address,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
        'role' => Roles::EMPLOYEE,
        'position_id' => rand(3, Position::count()),
        'is_blocked' => $dismissed,
        'comment' => $dismissed ? null : 'Уволен',
    ];
});
