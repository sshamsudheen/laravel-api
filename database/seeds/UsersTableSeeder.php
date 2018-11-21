<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      User::truncate();

      $faker = \Faker\Factory::create();


      $password = Hash::make('password');

      User::create([
          'name' => 'Administrator',
          'email' => 'admin@test.com',
          'password' => $password,
      ]);

      // And now let's generate a few dozen users for our app:
      for ($i = 0; $i < 10; $i++) {
          User::create([
              'name' => $faker->name,
              'email' => $faker->email,
              'password' => $password,
          ]);
      }
    }
}
