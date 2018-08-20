<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create('zh_TW');

        \App\User::create([
            'name'     => $faker->firstName,
            'email'    => 'orgates@gmail.com',
            'password' => bcrypt('123456'),
            'enable'   => 1
        ]);

        foreach (range(1,40) as $index){
            \App\User::create([
                'name'     => $faker->firstName,
                'email'    => 'orgates'.$index.'@gmail.com',
                'password' => bcrypt('123456'),
                'enable'   => 1
            ]);
        }
    }
}
