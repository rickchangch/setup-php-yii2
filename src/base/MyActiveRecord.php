<?php

namespace app\base;

use Faker\Provider\Uuid;
use yii\db\ActiveRecord;
use yii2tech\ar\softdelete\SoftDeleteBehavior;
use yii\behaviors\AttributesBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

class MyActiveRecord extends ActiveRecord
{
    const SOFTDEL_FIELD = 'is_deleted';
    const SOFTDEL_VAL_ALIVE = 0;
    const SOFTDEL_VAL_DEAD = 1;

    public function behaviors()
    {
        return [
            // uuid
            'uuidBehavior' => [
                'class' => AttributesBehavior::class,
                'attributes' => [
                    'id' => [
                        ActiveRecord::EVENT_BEFORE_INSERT => function () {
                            return Uuid::uuid();
                        },
                    ]
                ],
            ],
            // soft delete
            'softDeleteBehavior' => [
                'class' => SoftDeleteBehavior::class,
                'softDeleteAttributeValues' => [
                    self::SOFTDEL_FIELD => true,
                    'deleted_at' => new Expression('NOW()'),
                ],
            ],
            // record timestamp
            'timestampBehavior' => [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
                'value' => new Expression('NOW()'),
            ],
        ];
    }
}
