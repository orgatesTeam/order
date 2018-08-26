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

    protected function addTaste()
    {
        $iceHoneyOptions = [
            $this->addOption('冰塊', ['去冰', '微冰', '少冰', '正常']),
            $this->addOption('甜度', ['無糖', '微糖(三分)', '半糖(五分)', '少糖(七分)', '正常']),
        ];

        $iceHoneyOptions2 = [
            $this->addOption('冰/熱', ['去冰', '微冰', '少冰', '正常冰', '常溫', '熱']),
            $this->addOption('甜度', ['無糖', '微糖(三分)', '半糖(五分)', '少糖(七分)', '正常']),
        ];

        $size = [
            $this->addOption('容量', ['大杯 (700cc)', '小杯 (500cc)']),
        ];

        $hot = [
            $this->addOption('辣/不辣', ['大辣', '小辣', '不辣']),
        ];

        $user = \App\User::first();
        \App\Taste::create([
            'user_id' => $user->id,
            'name'    => '甜度/冰塊',
            'options' => json_encode($iceHoneyOptions)
        ]);
        \App\Taste::create([
            'user_id' => $user->id,
            'name'    => '甜度/冰塊(可選熱)',
            'options' => json_encode($iceHoneyOptions2)
        ]);
        \App\Taste::create([
            'user_id' => $user->id,
            'name'    => '容量',
            'options' => json_encode($size)
        ]);
        \App\Taste::create([
            'user_id' => $user->id,
            'name'    => '辣/不辣',
            'options' => json_encode($hot)
        ]);
    }

    protected function addOption($name, $checks)
    {
        $formatterChecks = [];
        foreach ($checks as $check) {
            $formatterChecks[] = ['name' => $check];
        }
        return [
            'name'   => $name,
            'checks' => $formatterChecks
        ];
    }
}
