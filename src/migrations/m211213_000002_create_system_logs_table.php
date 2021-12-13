<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%system_logs}}`.
 */
class m211213_000002_create_system_logs_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';

        $this->createTable('{{%system_logs}}', [
            'id' => $this->string(36)->notNull(),
            'user_id' => $this->string(36)->notNull(),
            'action' => "ENUM('login', 'logout')",
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
            'is_deleted' => $this->boolean()->defaultValue(false),
        ], $tableOptions);

        $this->addPrimaryKey('pk_id', 'system_logs', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%system_logs}}');
    }
}
