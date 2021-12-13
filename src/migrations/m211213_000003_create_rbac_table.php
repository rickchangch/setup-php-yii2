<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%rbac}}`.
 */
class m211213_000003_create_rbac_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // Table collation
        $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';

        /*
         * Create auth_rule table
         */
        $this->createTable('auth_rule', [
            'name' => $this->string(64)->notNull(),
            'data' => $this->binary(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions);

        // PK
        $this->addPrimaryKey('pk_name', 'auth_rule', 'name');

        /*
         * Create auth_item table
         */
        $this->createTable('auth_item', [
            'name' => $this->string(64)->notNull(),
            'type' => $this->smallInteger()->notNull(),
            'description' => $this->text(),
            'rule_name' => $this->string(64),
            'data' => $this->binary(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions);

        // PK
        $this->addPrimaryKey('pk_name', 'auth_item', 'name');

        // FK
        $this->addForeignKey('fk_auth_item_rule_name_auth_rule_name', 'auth_item', 'rule_name', 'auth_rule', 'name', null, 'CASCADE');

        // Secondary index
        $this->createIndex('ix_auth_item_type', 'auth_item', 'type');

        /*
         * Create auth_item_child table
         */
        $this->createTable('auth_item_child', [
            'parent' => $this->string(64)->notNull(),
            'child' => $this->string(64)->notNull(),
        ], $tableOptions);

        // PK
        $this->addPrimaryKey('pk_auth_item_child', 'auth_item_child', ['parent', 'child']);

        // FK
        $this->addForeignKey('fk_auth_item_child_parent_auth_item_name', 'auth_item_child', 'parent', 'auth_item', 'name', 'CASCADE', 'CASCADE');

        // FK
        $this->addForeignKey('fk_auth_item_child_child_auth_item_name', 'auth_item_child', 'child', 'auth_item', 'name', 'CASCADE', 'CASCADE');

        /*
         * Create table: auth_assignment
         */
        $this->createTable('auth_assignment', [
            'item_name' => $this->string(64)->notNull(),
            'user_id' => $this->string(64)->notNull(),
            'created_at' => $this->integer(),
        ], $tableOptions);

        // PK
        $this->addPrimaryKey('pk_auth_assignment', 'auth_assignment', ['item_name', 'user_id']);

        // FK
        $this->addForeignKey('fk_auth_assignment_item_name_auth_item_name', 'auth_assignment', 'item_name', 'auth_item', 'name', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('auth_assignment');
        $this->dropTable('auth_item_child');
        $this->dropTable('auth_item');
        $this->dropTable('auth_rule');
    }
}
