<?php

use app\models\Account;
use yii\web\ErrorHandler;
use yii\web\JsonParser;

$common = require __DIR__ . '/common.php';
$routers = require __DIR__ . '/routers.php';

$config = array_merge_recursive($common, [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'container' => [
        'definitions' => [],
        'singletons' => [
            'AccountComponent' => [
                'class' => 'app\components\AccountComponent',
            ],
            'AuthItemComponent' => [
                'class' => 'app\components\AuthItemComponent',
            ],
            'SystemLogsComponent' => [
                'class' => 'app\components\SystemLogsComponent',
            ],
        ],
    ],
    'components' => [
        'request' => [
            'enableCookieValidation' => true,
            'cookieValidationKey' => $_ENV['COOKIE_VALIDATION_KEY'],
            'parsers' => [
                'application/json' => JsonParser::class,
            ],
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => Account::class,
            'enableAutoLogin' => true,
            'enableSession' => true,
            'loginUrl' => ['entry'],
        ],
        'errorHandler' => [
            'class' => ErrorHandler::class,
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            // 'enableStrictParsing' => true,
            'rules' => $routers,
        ],
    ],
]);

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['127.0.0.1', '::1', '192.*', '172.*'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['127.0.0.1', '::1', '192.*', '172.*'],
    ];
}

return $config;
