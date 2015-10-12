<?php

return [
    'paths' => [
        'src'    => __DIR__ . '/../../',
        'public' => __DIR__ . '/../../../public/',
    ],

    // ------------------------------------------

    'urls' => [
        'backoffice' => 'http://backoffice.mqh.dev',
        'api'        => 'http://api.mqh.dev',
    ],

    // ------------------------------------------

    'databases' => [
        'mysql' => [
            'localhost' => [
                'host'   => getenv('MYSQL_HOST'),
                'user'   => getenv('MYSQL_USER'),
                'pass'   => getenv('MYSQL_PASS'),
                'dbname' => 'mqh_dev_core',
            ],
        ],

        'redis' => [
            'localhost' => [
                'host'     => getenv('REDIS_HOST'),
                'port'     => getenv('REDIS_PORT'),
                'dbIndex'  => 0,
                'password' => null,
            ],
        ],
    ],

    // ------------------------------------------

    'locales' => [
        'default'   => 'en',
        'available' => ['en', 'de'],
    ],
];
