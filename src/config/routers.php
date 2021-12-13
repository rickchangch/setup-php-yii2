<?php

use yii\web\UrlRule as WebUrlRule;
use app\base\MyRestUrlRule as RestUrlRule;

// create URLs to support rendering view
$web = [
    [
        // default
        'class' => WebUrlRule::class,
        'pattern' => '',
        'route' => 'home/index',
    ],
    [
        // system logs
        'class' => WebUrlRule::class,
        'pattern' => 'systemLogs',
        'route' => 'system-logs/index',
    ],
];

// create URLs to support handling the REST API endpoints
$rest = [
    [
        // account
        'class' => RestUrlRule::class,
        'prefix' => 'api/v1',
        'controller' => [
            'accounts' => 'api/v1/account',
        ],
        'extraPatterns' => [
            'POST login' => 'login',
            'POST logout' => 'logout',
            'POST register' => 'register',
            'GET listWithRoleInfo' => 'list-with-role-info',
        ],
    ],
    [
        // auth_item
        'class' => RestUrlRule::class,
        'prefix' => 'api/v1',
        'controller' => [
            'authItems' => 'api/v1/auth-item',
        ],
        'extraPatterns' => [
            'GET getRoles' => 'get-roles',
            'GET getPermissions' => 'get-permissions',
            'GET getRelationships' => 'get-relationships',
            'POST assignRoles' => 'assign-roles',
            'POST createRelationship' => 'create-relationship',
            'POST updateRelationship' => 'update-relationship',
        ],
    ],
    [
        // system_logs
        'class' => RestUrlRule::class,
        'prefix' => 'api/v1',
        'controller' => [
            'systemLogs' => 'api/v1/system-logs',
        ],
        'extraPatterns' => [
            'GET listWithUserInfo' => 'list-with-user-info'
        ],
    ],
];

return array_merge_recursive($web, $rest);
