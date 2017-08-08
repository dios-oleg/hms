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
$factory->define(App\Models\User::class, function (Faker\Generator $faker) 
{
    $faker = Faker\Factory::create('ru_RU');

    // определяем пол и фамилии
    $gender = $faker->boolean(60);
    $lastName = $faker->lastName;
    $lastNamePrint = $lastName;

    // уволен
    $dismissed = $faker->boolean(15);

    return [
        'first_name' => $gender ? $faker->firstNameMale : $faker->firstNameFemale,
        'last_name' => $gender ? $lastName : $lastName.'а',
        'last_name_print' => $gender ? $lastNamePrint.'a' : $lastNamePrint.'ой',
        'patronymic' => $gender ? $faker->middleNameMale : $faker->middleNameFemale,
        'email' => $faker->unique()->safeEmail, // FIXME почему-то не всегда уникальный из-за чего выскакивает исключение
        'address' => $faker->address.', '.$faker->address,
        'password' => $faker->password(6),
        'remember_token' => str_random(10),
        'role' => $faker->boolean(15) ? Roles::LEADER : Roles::EMPLOYEE,
        'position_id' => rand(3, Position::count()),
        'is_blocked' => $dismissed,
        'comment' => $dismissed ? null : 'Уволен',
    ];
});
