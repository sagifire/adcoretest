<?php

ini_set('display_errors', 1);

require(__DIR__ . '/../vendor/autoload.php');
$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

defined('YII_DEBUG') or define('YII_DEBUG', ($_ENV['YII_DEBUG']) ? true : false);
defined('YII_ENV') or define('YII_ENV', $_ENV['YII_ENV'] ?: 'prod');

require(__DIR__ . '/../vendor/yiisoft/yii2/Yii.php');

$config = require(__DIR__ . '/../config/web.php');

(new yii\web\Application($config))->run();