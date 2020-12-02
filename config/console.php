<?php
return [
    'id' => 'adcore-test-console',
    'basePath' => dirname(__DIR__),
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=' . $_ENV['APP_DB_NAME'],
            'username' => $_ENV['APP_DB_USER'],
            'password' => $_ENV['APP_DB_PASSWORD'],
            'charset' => 'utf8',
        ],
    ],
];