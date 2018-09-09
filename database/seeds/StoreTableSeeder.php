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
        $stores = [];
        foreach ($this->stores() as $store) {
            $stores[] = \App\Store::create([
                'user_id' => $user->id,
                'name'    => $store['name'],
                'tel'     => '02-22288445',
                'address' => '台北市信義區336巷',
                'table_total' => '5'
            ]);
        }

        foreach ($stores as $index => $store) {
            $range = $index == 0 ?
                [1,
                    30
                ] : [31,
                    60
                ];
            foreach (range($range[0], $range[1]) as $menuID) {
                App\StoreMenu::create([
                    'store_id'    => $store->id,
                    'menu_id'     => $menuID,
                ]);
            }
        }
    }

    protected function stores()
    {
        return [
            ['name' => 'coco2嘟可'],
            ['name' => '麥當勞'],
            ['name' => '八方雲集'],
            ['name' => '牛排教父'],
            ['name' => 'is pasta']
        ];
    }
}
