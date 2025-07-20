<?php

return [
    'gateways' => [
        'bank1' => [
            'name' => 'Bank1Gateway',
            'api_key' => env('BANK1_API_KEY', 'bank1-demo-key'),
        ],
        'bank2' => [
            'name' => 'Bank2Gateway',
            'api_key' => env('BANK2_API_KEY', 'bank2-demo-key'),
        ],
        'bank3' => [
            'name' => 'Bank3Gateway',
            'api_key' => env('BANK3_API_KEY', 'bank3-demo-key'),
        ],
    ],
];
