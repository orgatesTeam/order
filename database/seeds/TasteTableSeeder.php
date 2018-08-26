<?php

use Illuminate\Database\Seeder;

class TasteTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
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
