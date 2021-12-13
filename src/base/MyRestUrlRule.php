<?php

namespace app\base;

use yii\rest\UrlRule;

class MyRestUrlRule extends UrlRule {
    /**
     * {@inheritDoc}
     */
    public $tokens = [
        '{id}' => '<id:[0-9a-z\\-][0-9a-z\\-]*>',
    ];
}
