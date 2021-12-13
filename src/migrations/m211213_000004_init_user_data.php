<?php

use app\models\Account;
use yii\db\Migration;

/**
 * Class m211213_000004_init_user_data
 */
class m211213_000004_init_user_data extends Migration
{
    private function _newUser()
    {
        // create new user
        $security = Yii::$app->getSecurity();

        $newAccount = new Account();
        $newAccount->username = 'user01';
        $newAccount->password = $security->generatePasswordHash('user01');
        $newAccount->auth_key = $security->generateRandomString();
        $newAccount->save();

        $newAccount2 = new Account();
        $newAccount2->username = 'user02';
        $newAccount2->password = $security->generatePasswordHash('user02');
        $newAccount2->auth_key = $security->generateRandomString();
        $newAccount2->save();

        return [
            $newAccount->username => $newAccount->getPrimaryKey(),
            $newAccount2->username => $newAccount2->getPrimaryKey(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $users = $this->_newUser();

        // create new role & permission
        $auth = Yii::$app->authManager;

        $crudRolePm = $auth->createPermission('role.crud');
        $crudRolePm->description = 'operate role CRUD';
        $auth->add($crudRolePm);

        $readUserPm = $auth->createPermission('user.read');
        $readUserPm->description = 'read user info';
        $auth->add($readUserPm);

        $useless = $auth->createPermission('useless.01');
        $useless->description = 'useless01';
        $auth->add($useless);
        $useless = $auth->createPermission('useless.02');
        $useless->description = 'useless02';
        $auth->add($useless);

        $admin = $auth->createRole('admin');
        $auth->add($admin);
        $auth->addChild($admin, $crudRolePm);
        $auth->addChild($admin, $readUserPm);

        $user = $auth->createRole('user');
        $auth->add($user);
        $auth->addChild($user, $readUserPm);

        $auth->assign($admin, $users['user01']);
        $auth->assign($user, $users['user02']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // clean account table
        $this->truncateTable('account');

        // clean RBAC-related tables
        $this->db->createCommand()->checkIntegrity(false)->execute();
        $this->truncateTable('auth_assignment');
        $this->truncateTable('auth_item_child');
        $this->truncateTable('auth_item');
        $this->truncateTable('auth_rule');
        $this->db->createCommand()->checkIntegrity(true)->execute();
    }
}
