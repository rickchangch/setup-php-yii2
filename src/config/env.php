<?php

use Dotenv\Dotenv;
use Dotenv\Repository\Adapter\EnvConstAdapter;
use Dotenv\Repository\RepositoryBuilder;

$repository = RepositoryBuilder::createWithNoAdapters()
    ->addAdapter(EnvConstAdapter::class)
    ->immutable()
    ->make();
$dotenv = Dotenv::create($repository, __DIR__ . '/../', '.env');
$dotenv->load();

$dotenv->required('YII_ENV')->allowedValues(['test', 'dev', 'prod']);
$dotenv->required('YII_DEBUG')->isBoolean();

defined('YII_ENV') or define('YII_ENV', $_ENV['YII_ENV']);
defined('YII_DEBUG') or define('YII_DEBUG', $_ENV['YII_DEBUG']);
