<?php

namespace app\components;

use app\models\Account;
use Exception;
use Yii;
use yii\base\Component;

class AccountComponent extends Component
{
    /**
     * get account by username
     *
     * @param string $username
     * @return mixed
     */
    public function getByUsername($username)
    {
        return Account::find()
            ->where(['username' => $username])
            ->one();
    }

    /**
     * list accounts data with role info
     *
     * @return array
     */
    public function listWithRoleInfo()
    {
        $res = [
            'data' => [],
            'canModify' => false,
        ];

        $res['data'] = Account::find()
            ->select('account.id, account.username, account.created_at, auth_assignment.item_name')
            ->leftJoin('auth_assignment', 'auth_assignment.user_id = account.id')
            ->andWhere(['account.is_deleted' => 0])
            ->asArray()->all();

        $res['canModify'] = Yii::$app->user->can('role.Crud');

        return $res;
    }

    /**
     * create a new user
     *
     * @param string $data
     */
    public function createUser($data)
    {
        $account = new Account();
        $account->username = $data['username'];
        $account->password = Yii::$app->security->generatePasswordHash($data['password']);

        if (!$account->save()) {
            $errors = $account->getErrorSummary(true);
            throw new Exception(implode(PHP_EOL, $errors), 400);
        }
    }
}
