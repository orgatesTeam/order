<?php

use Illuminate\Database\Seeder;

class MenuTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = \App\User::first();
        foreach (range(1, 40) as $index) {
            \App\Menu::create([
                'user_id'      => $user->id,
                'name'         => '牛排' . $index,
                'price'        => $index * 10,
                'menu_type_id' => 1
            ]);
        }

        foreach (range(1, 3) as $index) {
            \App\MenuType::create([
                'user_id' => $user->id,
                'name'    => '主菜'
            ]);
        }
    }
}
