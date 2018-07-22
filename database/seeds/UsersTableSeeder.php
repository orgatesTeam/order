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
        \App\User::create([
            'name' => 'orgates',
            'email' => 'orgates@gmail.com',
            'password' => bcrypt('123456'),
        ]);
    }
}
