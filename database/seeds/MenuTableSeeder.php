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
        foreach ($this->menus() as $menu) {
            \App\Menu::create([
                'user_id'      => $user->id,
                'name'         => $menu['name'],
                'price'        => $menu['price'],
                'menu_type_id' => $menu['type'],
                'taste_ids'    => $menu['taste_ids'] ?? ''
            ]);
        }

        $types = ['主食(飯類)',
            '主食(麵類)',
            '主食(肉類)',
            '下酒菜',
            '開胃菜',
            '前菜',
            '主菜'
        ];
        foreach ($types as $type) {
            \App\MenuType::create([
                'user_id' => $user->id,
                'name'    => $type
            ]);
        }

        $this->addTastes();
    }

    protected function addTastes()
    {
        $iceHoneyOptions = [
            $this->addOption('冰塊', ['去冰',
                '微冰',
                '少冰',
                '正常'
            ]),
            $this->addOption('甜度', ['無糖',
                '微糖(三分)',
                '半糖(五分)',
                '少糖(七分)',
                '正常'
            ]),
        ];

        $iceHoneyOptions2 = [
            $this->addOption('冰/熱', ['去冰',
                '微冰',
                '少冰',
                '正常冰',
                '常溫',
                '熱'
            ]),
            $this->addOption('甜度', ['無糖',
                '微糖(三分)',
                '半糖(五分)',
                '少糖(七分)',
                '正常'
            ]),
        ];

        $size = [
            $this->addOption('容量', ['大杯 (700cc)',
                '小杯 (500cc)'
            ]),
        ];

        $hot = [
            $this->addOption('辣/不辣', ['大辣',
                '小辣',
                '不辣'
            ]),
        ];

        $pepper = [
            $this->addOption('醬料(黑胡椒、蘑菇)', ['蘑菇',
                '黑胡椒'
            ]),
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
        \App\Taste::create([
            'user_id' => $user->id,
            'name'    => '醬料(黑胡椒、蘑菇)',
            'options' => json_encode($pepper)
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

    protected function menus()
    {
        return [
            ['name'      => '餛飩麵',
             'price'     => '55',
             'type'      => '1',
             'taste_ids' => '1,2'
            ],
            ['name'      => '水餃',
             'price'     => '5',
             'type'      => '1',
             'taste_ids' => '1,2'

            ],
            ['name'      => '鍋貼',
             'price'     => '5',
             'type'      => '1',
             'taste_ids' => '1,2'
            ],
            ['name'      => '古早味乾麵',
             'price'     => '35',
             'type'      => '1',
             'taste_ids' => '1,2'
            ],
            ['name'      => '泡菜梅花豬肉義大利麵',
             'price'     => '145',
             'type'      => '1',
             'taste_ids' => '1,2'
            ],
            ['name'      => '茄汁培根義大利麵',
             'price'     => '130',
             'type'      => '1',
             'taste_ids' => '1,2'
            ],
            ['name'      => '酸辣湯麵',
             'price'     => '55',
             'type'      => '1',
             'taste_ids' => '1,2'
            ],
            ['name'      => '蕈菇湯',
             'price'     => '30',
             'type'      => '7',
             'taste_ids' => '1,2'
            ],
            ['name'      => '酸辣湯',
             'price'     => '30',
             'type'      => '7',
             'taste_ids' => '1,2'
            ],
            ['name'      => '玉米濃湯',
             'price'     => '30',
             'type'      => '7',
             'taste_ids' => '1,2'
            ],
            ['name'      => '酸辣涼拌雞胸肉',
             'price'     => '50',
             'type'      => '4',
             'taste_ids' => '1,2'
            ],
            ['name'  => '梅漬番茄',
             'price' => '35',
             'type'  => '4'
            ],
            ['name'  => '鮮蝦蘋果起司沙拉',
             'price' => '40',
             'type'  => '4'
            ],
            ['name'  => '蒜炒魩仔魚',
             'price' => '45',
             'type'  => '4'
            ],
            ['name'  => '奶油燻雞義式燉飯',
             'price' => '130',
             'type'  => '1'
            ],
            ['name'  => '番茄肉醬義式燉飯',
             'price' => '125',
             'type'  => '1'
            ],
            ['name'  => '海鮮焗烤飯',
             'price' => '140',
             'type'  => '1'
            ],
            ['name'  => '普羅旺斯嫩雞奶油及烤飯',
             'price' => '140',
             'type'  => '1'
            ],
            ['name'  => '老饕牛排',
             'price' => '190',
             'type'  => '2'
            ],
            ['name'      => '主廚牛排',
             'price'     => '150',
             'type'      => '2',
             'taste_ids' => '5'
            ],
            ['name'      => '後切沙郎牛排',
             'price'     => '250',
             'type'      => '2',
             'taste_ids' => '5'
            ],
            ['name'      => '主廚豬排排',
             'price'     => '150',
             'type'      => '2',
             'taste_ids' => '5'
            ],
            ['name'  => '三杯炒螺肉',
             'price' => '80',
             'type'  => '3'
            ],
            ['name'  => '香滷豆干',
             'price' => '60',
             'type'  => '3'
            ],
            ['name'  => '塔香蕈菇豬肉絲',
             'price' => '100',
             'type'  => '3'
            ],
            ['name'  => '豆干小辣椒',
             'price' => '60',
             'type'  => '3'
            ],
            ['name'  => '櫻桃鴨燻鴨胸沙拉',
             'price' => '170',
             'type'  => '5'
            ],
            ['name'  => '桌邊現拌凱撒沙拉',
             'price' => '170',
             'type'  => '5'
            ],
            ['name'      => '手工醃漬櫻桃蕃茄配水牛乳酪沙拉',
             'price'     => '190',
             'type'      => '5',
             'taste_ids' => '4'
            ],
            ['name'      => '鮮蝦炒蘑菇',
             'price'     => '190',
             'type'      => '5',
             'taste_ids' => '5'
            ],
            ['name'      => '紅燒豆腐',
             'price'     => '70',
             'type'      => '6',
             'taste_ids' => '5'
            ],
            ['name'      => '洋蔥煎肉餅',
             'price'     => '80',
             'type'      => '6',
             'taste_ids' => '5'
            ],
            ['name'      => '照燒雞肉',
             'price'     => '80',
             'type'      => '6',
             'taste_ids' => '5'
            ],
            ['name'      => '黑椒豬柳',
             'price'     => '85',
             'type'      => '6',
             'taste_ids' => '5'
            ]
        ];
    }
}
