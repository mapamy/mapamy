<?php

require __DIR__ . '/init.php';

return
[
    'paths' => [
        'migrations' => '%%PHINX_CONFIG_DIR%%/db/migrations',
        'seeds' => '%%PHINX_CONFIG_DIR%%/db/seeds'
    ],
    'environments' => [
        'default_migration_table' => 'phinxlog',
        'default_environment' => 'development',
        'development' => [
            'adapter' => 'pgsql',
            'host' => $_ENV['DB_HOST'],
            'name' => $_ENV['DB_NAME'],
            'user' => $_ENV['DB_USER'],
            'pass' => $_ENV['DB_PASS'],
            'port' => $_ENV['DB_PORT'],
            'charset' => 'utf8',
        ],
        'production' => [
            'adapter' => 'pgsql',
            'host' => 'your_production_host',
            'name' => 'your_production_db',
            'user' => 'your_production_user',
            'pass' => 'your_production_pass',
            'port' => 5432,
            'charset' => 'utf8',
        ]
    ],
    'version_order' => 'creation'
];
