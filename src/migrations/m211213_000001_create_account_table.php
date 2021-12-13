<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%account}}`.
 */
class m211213_000001_create_account_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';

        $this->createTable('{{%account}}', [
            'id' => $this->string(36)->notNull(),
            'username' => $this->string(255)->notNull(),
            'password' => $this->string(255)->notNull(),
            'auth_key' => $this->string(32)->notNull(),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
            'deleted_at' => $this->dateTime(),
            'is_deleted' => $this->boolean()->defaultValue(false),
        ], $tableOptions);

        $this->addPrimaryKey('pk_id', 'account', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%account}}');
    }
}
