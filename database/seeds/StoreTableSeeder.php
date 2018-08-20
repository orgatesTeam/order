<?php

use Illuminate\Database\Seeder;

class StoreTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = \App\User::first();

        $information = [
            'email' => 'bafun@gmail.com',
            'fb'    => 'bafun@gmail.com',
        ];

        $information2 = [
            'email' => 'cooc@gmail.com',
            'fb'    => 'coco@gmail.com',
        ];

        $store = \App\Store::create([
            'user_id'     => $user->id,
            'name'        => '八方雲集',
            'tel'         => '02-22288445',
            'address'     => '台北市信義區336巷',
            'information' => json_encode($information)
        ]);

        $store2 = \App\Store::create([
            'user_id'     => $user->id,
            'name'        => 'coco嘟可',
            'tel'         => '02-22288445',
            'address'     => '新北市蘆洲區長榮路',
            'information' => json_encode($information2)
        ]);

        $store3 = \App\Store::create([
            'user_id'     => $user->id,
            'name'        => '麥當勞',
            'tel'         => '02-22288445',
            'address'     => '新北市板橋區長榮路',
            'information' => json_encode($information2)
        ]);

        foreach (range(1, 20) as $index) {
            App\StoreMenu::create([
                'store_id' => $store->id,
                'menu_id'  => $index
            ]);
        }

        foreach (range(21, 40) as $index) {
            App\StoreMenu::create([
                'store_id' => $store2->id,
                'menu_id'  => $index
            ]);
        }

    }
}
