<?php

return [
    'paths'        => [
        'migrations' => __DIR__ . '/builds/sql',
    ],
    'environments' => [
        'default_migration_table' => 'utils_phinxlog',
        'default_database'        => 'dev',
        'dev'                     => [
            'adapter' => 'mysql',
            'host'    => getenv('MYSQL_HOST'),
            'user'    => getenv('MYSQL_USER'),
            'pass'    => getenv('MYSQL_PASS'),
            'name'    => 'mqh_dev_app',
        ],
        'staging'                 => [
            'adapter' => 'mysql',
            'host'    => getenv('MYSQL_HOST'),
            'user'    => getenv('MYSQL_USER'),
            'pass'    => getenv('MYSQL_PASS'),
            'name'    => 'mqh_staging_app',
        ],
        'production'              => [
            'adapter' => 'mysql',
            'host'    => getenv('MYSQL_HOST'),
            'user'    => getenv('MYSQL_USER'),
            'pass'    => getenv('MYSQL_PASS'),
            'name'    => 'mqh_production_app',
        ],
    ],
];
