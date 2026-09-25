<?php

return [
    'providers' => [
    ],
    /*
    |--------------------------------------------------------------------------
    | Uniqueness Strategy
    |--------------------------------------------------------------------------
    |
    | 'none'  → No uniqueness check at all.
    | 'check' → Application-level check before create/update/restore.
    |           Fast, single-server. Race-prone.
    | 'lock'  → Like 'check' + cache lock. Multi-server safe.
    |           Requires redis/memcached/database cache driver.
    |
    */
    'unique' => env('MTM_UNIQUE', 'check'),

    'lock' => [
        'timeout' => 10,
        'wait'    => 3,
        'prefix'  => 'mtm:unique:',
    ],
];
