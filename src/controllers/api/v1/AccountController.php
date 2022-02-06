<?php

namespace app\controllers\api\v1;

use app\models\Account;
use Exception;
use Yii;
use yii\rest\ActiveController;
use yii\web\BadRequestHttpException;
use yii\web\HttpException;

/**
 * AccountController implements the CRUD actions for Account model.
 */
class AccountController extends ActiveController
{
    /**
     * {@inheritDoc}
     * @var Account
     */
    public $modelClass = Account::class;

    /**
     * list accounts data with role info
     */
    public function actionListWithRoleInfo()
    {
        $this->response->setStatusCode(200);
        return Yii::$container
            ->get('AccountComponent')
            ->listWithRoleInfo();
    }

    /**
     * login
     */
    public function actionLogin()
    {
        $bodyParams = $this->request->post();

        // get account
        $account = Yii::$container
            ->get('AccountComponent')
            ->getByUsername($bodyParams['username']);

        if (!isset($account)) {
            throw new HttpException(404, 'The account you tried to login not exist.');
        }

        if (!Yii::$app->security->validatePassword($bodyParams['password'], $account['password'])) {
            throw new HttpException(400, 'Incorrect password.');
        }

        try {

            // login
            Yii::$app->user->login($account, 1);

            // record login log
            Yii::$container
                ->get('SystemLogsComponent')
                ->record('login');

        } catch (Exception $e) {
            throw new HttpException($e->getCode(), $e->getMessage());
        }

        // OK
        return $this->response->setStatusCode(200);
    }

    /**
     * logout
     */
    public function actionLogout()
    {
        try {

            // record logout log
            Yii::$container
                ->get('SystemLogsComponent')
                ->record('logout');

            // logout
            Yii::$app->user->logout();

        } catch (Exception $e) {

            throw new HttpException($e->getCode(), $e->getMessage());
        }

        $this->response->setStatusCode(200);

        return $this->goHome();
    }

    /**
     * register
     */
    public function actionRegister()
    {
        $bodyParams = $this->request->post();

        if ($bodyParams['password'] !== $bodyParams['password2']) {
            throw new BadRequestHttpException('Sencond password does not match primary password.');
        }

        try {
            // create new user
            Yii::$container
                ->get('AccountComponent')
                ->createUser($bodyParams);
        } catch (Exception $e) {
            throw new HttpException($e->getCode(), $e->getMessage());
        }

        return $this->response->setStatusCode(201);
    }
}
