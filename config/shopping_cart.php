<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Shopping cart config
    |--------------------------------------------------------------------------
    */
    
    'format_numbers' => false,
    'decimals' => 0,
    'dec_point' => '.',
    'thousands_sep' => ',',

    'storage' => [
        'driver' => 'session',
        'key' => 'cart_id',
        'lifetime' => 120
    ]
];
