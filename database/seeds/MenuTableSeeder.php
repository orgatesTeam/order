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

        $types = ['主食(飯類)', '主食(麵類)', '主食(肉類)', '下酒菜', '開胃菜', '前菜', '主菜'];
        foreach ($types as $type) {
            \App\MenuType::create([
                'user_id' => $user->id,
                'name'    => $type
            ]);
        }
    }
}
