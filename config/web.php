<?php
return [
    'id' => 'adcore-test-api',
    'basePath' => dirname(__DIR__),
    'defaultRoute' => 'api/index',
    'components' => [
        'requestLogger' => [
            'class' => 'app\components\RequestLogger',
            'logFile' => '@app/runtime/requests.txt',
        ],
        'request' => [
            'class' => 'yii\web\Request',
            'enableCsrfValidation' => false,
            'cookieValidationKey' => 'GhAcZ2j2hHCv9-XMRK1mi0wYRu29SWwu',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ],
        ],
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=' . $_ENV['APP_DB_NAME'],
            'username' => $_ENV['APP_DB_USER'],
            'password' => $_ENV['APP_DB_PASSWORD'],
            'charset' => 'utf8',
        ],
    ],
];