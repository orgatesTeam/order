<?php

namespace App\Repositories\Taste;

use Yish\Generators\Foundation\Repository\Repository;

class OptionsRepository extends Repository
{
    const PRICE_KEY = 'price';
    const OPTION_ID = 'option_id';
    const CHECK_ID = 'check_id';

    protected function addOptionExample()
    {
        $iceHoneyOptions = $this->formatterOptions([
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
        ]);

        $user = \App\User::first();
        \App\Taste::create([
            'user_id' => $user->id,
            'name'    => '甜度/冰塊',
            'options' => json_encode($iceHoneyOptions)
        ]);
    }

    /**
     * 1.帶入option_id
     * 2.帶入taste_id
     *
     * @param $options
     *
     * @return array
     */
    public function formatterOptions($options)
    {
        $newOptions = [];
        foreach ($options as $index => $option) {
            $makeOption = [];
            foreach ($option as $key => $value) {
                if ($key == 'checks') {
                    $value = $this->makeCheckID($value);
                }
                $makeOption[$key] = $value;
            }
            $makeOption[self::OPTION_ID] = $index + 1;
            $newOptions[] = $makeOption;
        }
        return $newOptions;
    }

    protected function makeCheckID($checks)
    {
        $newChecks = [];
        foreach ($checks as $index => $value) {
            $value[self::CHECK_ID] = $index + 1;
            $newChecks[] = $value;
        }
        return $newChecks;
    }

    public function addOption($name, $checks)
    {
        $formatterChecks = [];
        foreach ($checks as $key => $check) {
            $formatterChecks[] = [
                'name' => $check
            ];
        }
        return [
            'name'   => $name,
            'checks' => $formatterChecks
        ];
    }

    /**
     * 更新 option id
     * 更新 taste id
     *
     * @param String $options
     *
     * @return string
     */
    public function updateOptionIDTasteID(String $options)
    {
        $newOptions = [];
        $options = json_decode($options, true);
        foreach ($options as $index => $option) {
            $option = $this->updateTasteIDS($option);
            $option[self::OPTION_ID] = $index + 1;
            $newOptions[] = $option;
        }
        return json_encode($newOptions);
    }

    /**
     * 更新 option 內的 taste id
     *
     * @param $option
     *
     * @return mixed
     */
    protected function updateTasteIDS($option)
    {
        $newOption['name'] = $option['name'];
        $checks = [];
        foreach ($option['checks'] as $index => $check) {
            $check[self::CHECK_ID] = $index + 1;
            $checks[] = $check;
        }
        $newOption['checks'] = $checks;
        return $newOption;
    }

}
