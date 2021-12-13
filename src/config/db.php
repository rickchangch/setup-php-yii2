<?php

use yii\db\Connection;

$param = require __DIR__ . '/params.php';

return [
    'class' => Connection::class,
    'dsn' => "mysql:host={$params['db']['host']};dbname={$params['db']['dbname']}",
    'username' => $params['db']['user'],
    'password' => $params['db']['pwd'],
    'charset' => 'utf8',

    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];
