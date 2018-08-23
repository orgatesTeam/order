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
        $faker = Faker\Factory::create('zh_TW');

        $user = \App\User::first();

        $informations=[];

        foreach (range(0,4) as $index){

            $email = $faker->unique()->safeEmail;
            $informations[$index] =[$email,$email];

        };
/*
        $information = [
            'email' => 'bafun@gmail.com',
            'fb'    => 'bafun@gmail.com',
        ];

        $information2 = [
            'email' => 'cooc@gmail.com',
            'fb'    => 'coco@gmail.com',
        ];
*/
        foreach (range(1,5) as $index){

            \App\Store::create([
                'user_id'     => $user->id,
                'name'        => $faker->name,
                'tel'         => $faker->numerify($text='0#-########'),
                'address'     => "$faker->city"."$faker->streetAddress",
                'information' => json_encode($informations[$index-1])
            ]);

            for($i=0;$i<10;$i++){
                App\StoreMenu::create([
                    'store_id'  =>  $index,
                    'menu_id'   =>  $faker->numberBetween(1,40)
                ]);
            }
        }
        /*
        $store = \App\Store::create([
            'user_id'     => $user->id,
            'name'        => '八方雲集',
            'tel'         => '02-22288445',
            'address'     => '台北市信義區336巷',
            'information' => json_encode($informations[0])
        ]);

        $store2 = \App\Store::create([
            'user_id'     => $user->id,
            'name'        => 'coco嘟可',
            'tel'         => '02-22288445',
            'address'     => '新北市蘆洲區長榮路',
            'information' => json_encode($informations[1])
        ]);

        $store3 = \App\Store::create([
            'user_id'     => $user->id,
            'name'        => '麥當勞',
            'tel'         => '02-22288445',
            'address'     => '新北市板橋區長榮路',
            'information' => json_encode($informations[2])
        ]);
*/
        /*
        foreach (range(1, 20) as $index) {
            App\StoreMenu::create([
                'store_id' => 1,
                'menu_id'  => $index
            ]);
        }

        foreach (range(21, 40) as $index) {
            App\StoreMenu::create([
                'store_id' => 2,
                'menu_id'  => $index
            ]);
        }
*/
    }
}
