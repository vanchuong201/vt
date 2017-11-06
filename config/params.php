<?php

return [
    'adminEmail' => 'admin@example.com',

    'code_char_alpha' => '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz',
    'code_char' => 'abcdefghijklmnopqrstuvwxyz',
    'code_num' => '0123456789',


    // all service
    'all_service' => [
        1 => 'Chống giả',
        2 => 'Bảo hành',
        3 => 'Tràn hàng',
        4 => 'Chống giả - Bảo hành',
        5 => 'Chống giả - Tràn hàng',
        6 => 'Bảo hành - Tràn hàng',
        7 => 'Chống giả - Bảo hành - Tràn hàng',
        8 => 'Chống giả bằng số lần đếm',
    ],
    'service_has_guarantee' => [2,4,6,7],
    'service_has_tran_hang' => [3,5,6,7],
    'service_has_chong_gia' => [1,4,5,7],
    'service_has_chong_gia_bang_dem' => [8]
];
