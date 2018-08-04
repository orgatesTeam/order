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
            'name'     => 'orgates',
            'email'    => 'orgates@gmail.com',
            'password' => bcrypt('123456'),
            'enable'   => 1
        ]);

        foreach (range(1,40) as $index){
            \App\User::create([
                'name'     => 'orgates'.$index,
                'email'    => 'orgates'.$index.'@gmail.com',
                'password' => bcrypt('123456'),
                'enable'   => 1
            ]);
        }
    }
}
