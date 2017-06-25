<?php

use Illuminate\Database\Seeder;
use App\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
       //$this->call(\UsersTableSeeder::class);
    }
}

class UsersTableSeeder extends Seeder
{
    public function run() {
        DB::table('users')->delete();
        
        User::create([
           'first_name' => 'Иван',
           'last_name' => 'Иванов',
           'last_name_print' => 'Иванову',
           'patronymic' => 'Иванович',
           'email' => 'vano@iv.an',
           'address' => 'Иваново',
           'head' => true,
           'position_id' => '1',
           'password' => bcrypt('123'),
        ]);
        
        User::create([
           'first_name' => 'Петров',
           'last_name' => 'Петр',
           'last_name_print' => 'Петрову',
           'patronymic' => 'Петрович',
           'email' => 'peter@iv.an',
           'address' => 'Иваново',
           'head' => false,
           'position_id' => '2',
           'password' => bcrypt('123'), 
           'blocked' => false,
           'comment' => null,
        ]);
        
        User::create([
           'first_name' => 'Олег',
           'last_name' => 'Дмитроченко',
           'last_name_print' => 'Дмитроченко',
           'patronymic' => 'Сергеевич',
           'email' => 'dmitrochenkooleg@gmail.com',
           'address' => 'Витебск',
           'head' => true,
           'position_id' => '3',
           'password' => bcrypt('123456'), 
           'blocked' => false,
           'comment' => null,
        ]);
        
        User::create([
           'first_name' => 'Павел',
           'last_name' => 'Жуков',
           'last_name_print' => 'Жукова',
           'patronymic' => 'Владимирович',
           'email' => 'jukov@gmail.com',
           'address' => 'Витебск',
           'head' => true,
           'position_id' => '3',
           'password' => bcrypt('123456'), 
           'blocked' => false,
           'comment' => null,
        ]);
    }
}
