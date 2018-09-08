<?php 
return [
    'validateJwtToken' => [
        'name' => '安全驗證(JWT)',
        'type' => 'boolean',
        'value' => 'true',
    ],
    'webStatus' => [
        'name' => '網站狀態',
        'type' => 'select',
        'options' => [
            '上線' => '1',
            '維護' => '2',
            '部分維護' => '3',
        ],
        'value' => '1',
    ],
];