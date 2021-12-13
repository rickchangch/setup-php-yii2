<?php

use yii\rbac\DbManager;

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

return [
    'params' => $params,
    'components' => [
        'db' => $db,
        'authManager' => [
        'class' => DbManager::class,
        ],
    ],
];
