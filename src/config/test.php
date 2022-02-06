<?php

use app\models\Account;

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/test_db.php';
$routers = require __DIR__ . '/routers.php';

/**
 * Application configuration shared by all test types
 */
return [
    'id' => 'basic-tests',
    'basePath' => dirname(__DIR__),
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'language' => 'en-US',
    'components' => [
        'db' => $db,
        'mailer' => [
            'useFileTransport' => true,
        ],
        'assetManager' => [
            'basePath' => __DIR__ . '/../web/assets',
        ],
        'urlManager' => [
            // 'showScriptName' => true,
            'showScriptName' => false,
            'enablePrettyUrl' => true,
            'rules' => $routers,
        ],
        'user' => [
            'identityClass' => Account::class,
            'enableAutoLogin' => true,
            'enableSession' => true,
            'loginUrl' => ['entry'],
        ],
        'request' => [
            'cookieValidationKey' => 'test',
            'enableCsrfValidation' => false,
            // but if you absolutely need it set cookie domain to localhost
            /*
            'csrfCookie' => [
                'domain' => 'localhost',
            ],
            */
        ],
    ],
    'params' => $params,
];
