<?php

require_once __DIR__ . '/vendor/autoload.php';

$container = new Pimple\Container();

$container['db'] = function() {
    $pdo = new PDO(
        'pgsql:host='.getenv('APP_DB_HOST').
        ';port='.getenv('APP_DB_PORT').
        ';dbname='.getenv('APP_DB_NAME').
        ';user='.getenv('APP_DB_USER').
        ';password='.getenv('APP_DB_PASSWORD')
    );

    $pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

    return $pdo;
};

