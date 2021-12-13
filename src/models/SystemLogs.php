<?php

namespace app\models;

use app\base\MyActiveRecord;

/**
 * This is the model class for table "system_logs".
 *
 * @property string $id
 * @property string $user_id
 * @property string|null $action
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property int|null $is_deleted
 */
class SystemLogs extends MyActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'system_logs';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['action'], 'string'],
            [['id', 'created_at', 'updated_at'], 'safe'],
            [['is_deleted'], 'integer'],
            [['user_id'], 'string', 'max' => 36],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'action' => 'Action',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'is_deleted' => 'Is Deleted',
        ];
    }
}
