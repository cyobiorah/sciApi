<?php

use Illuminate\Database\Seeder;
use App\User;

// composer require laracasts/testdummy
use Laracasts\TestDummy\Factory as TestDummy;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        // TestDummy::times(20)->create('App\Post');
        $faker = Faker\Factory::create();

        foreach (range(1, 3) as $index)
        {
          User::create([
            'name' => $faker->name($gender = null|'male'|'female'),
            'email' => $faker->email,
            'nickname' => $faker->userName,
            'bio' => $faker->paragraph($nbSentences = 3, $variableNbSentences = true),
            'password' => bcrypt('secret')
          ]);
        }
    }
}
