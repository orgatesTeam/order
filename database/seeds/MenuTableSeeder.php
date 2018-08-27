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

        foreach ($this->mmMenus() as $menu) {
            \App\Menu::create([
                'user_id'      => $user->id,
                'name'         => $menu['name'],
                'price'        => $menu['price'],
                'menu_type_id' => $menu['type']
            ]);
        }

        $types = ['主食(飯類)', '主食(麵類)', '主食(肉類)', '下酒菜', '開胃菜', '前菜', '主菜', '湯類'];
        foreach ($types as $type) {
            \App\MenuType::create([
                'user_id' => $user->id,
                'name'    => $type
            ]);
        }
    }

    public function mmMenus()
    {
        return [
            ['name'=>'餛飩麵','price'=>'55','type'=>'1'],
            ['name'=>'水餃','price'=>'5','type'=>'1'],
            ['name'=>'鍋貼','price'=>'5','type'=>'1'],
            ['name'=>'古早味乾麵','price'=>'35','type'=>'1'],
            ['name'=>'泡菜梅花豬肉義大利麵','price'=>'145','type'=>'1'],
            ['name'=>'茄汁培根義大利麵','price'=>'130','type'=>'1'],
            ['name'=>'酸辣湯麵','price'=>'55','type'=>'1'],
            ['name'=>'蕈菇湯','price'=>'30','type'=>'7'],
            ['name'=>'酸辣湯','price'=>'30','type'=>'7'],
            ['name'=>'玉米濃湯','price'=>'30','type'=>'7'],
            ['name'=>'酸辣涼拌雞胸肉','price'=>'50','type'=>'4'],
            ['name'=>'梅漬番茄','price'=>'35','type'=>'4'],
            ['name'=>'鮮蝦蘋果起司沙拉','price'=>'40','type'=>'4'],
            ['name'=>'蒜炒魩仔魚','price'=>'45','type'=>'4'],
            ['name'=>'奶油燻雞義式燉飯','price'=>'130','type'=>'0'],
            ['name'=>'番茄肉醬義式燉飯','price'=>'125','type'=>'0'],
            ['name'=>'海鮮焗烤飯','price'=>'140','type'=>'0'],
            ['name'=>'普羅旺斯嫩雞奶油及烤飯','price'=>'140','type'=>'0'],
            ['name'=>'老饕牛排','price'=>'190','type'=>'2'],
            ['name'=>'主廚牛排','price'=>'150','type'=>'2'],
            ['name'=>'後切沙郎牛排','price'=>'250','type'=>'2'],
            ['name'=>'主廚豬排排','price'=>'150','type'=>'2'],
            ['name'=>'三杯炒螺肉','price'=>'80','type'=>'3'],
            ['name'=>'香滷豆干','price'=>'60','type'=>'3'],
            ['name'=>'塔香蕈菇豬肉絲','price'=>'100','type'=>'3'],
            ['name'=>'豆干小辣椒','price'=>'60','type'=>'3'],
            ['name'=>'櫻桃鴨燻鴨胸沙拉','price'=>'170','type'=>'5'],
            ['name'=>'桌邊現拌凱撒沙拉','price'=>'170','type'=>'5'],
            ['name'=>'手工醃漬櫻桃蕃茄配水牛乳酪沙拉','price'=>'190','type'=>'5'],
            ['name'=>'鮮蝦炒蘑菇','price'=>'190','type'=>'5'],
            ['name'=>'紅燒豆腐','price'=>'70','type'=>'6'],
            ['name'=>'洋蔥煎肉餅','price'=>'80','type'=>'6'],
            ['name'=>'照燒雞肉','price'=>'80','type'=>'6'],
            ['name'=>'黑椒豬柳','price'=>'85','type'=>'6']
            ];
    }
}
