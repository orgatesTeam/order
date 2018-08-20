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
        $faker = Faker\Factory::create('zh_TW');

        $user = \App\User::first();
        foreach (range(1, 40) as $index) {
            \App\Menu::create([
                'user_id'      => $user->id,
                'name'         => $faker->name(),
                'price'        => $faker->numberBetween(10, 1000),
                'menu_type_id' => $faker->numberBetween(1, 7)
            ]);
        }

        $types = ['主食(飯類)', '主食(麵類)', '主食(肉類)', '下酒菜', '開胃菜', '前菜', '主菜'];
        foreach ($types as $type) {
            \App\MenuType::create([
                'user_id' => $user->id,
                'name'    => $type
            ]);
        }
    }
}
