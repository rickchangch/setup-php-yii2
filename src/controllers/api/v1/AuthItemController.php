<?php

namespace app\controllers\api\v1;

use app\models\AuthItem;
use Exception;
use Yii;
use yii\rest\ActiveController;
use yii\web\HttpException;

/**
 * AuthItemController implements the CRUD actions for AuthItem model.
 */
class AuthItemController extends ActiveController
{
    /**
     * {@inheritDoc}
     * @var AuthItem
     */
    public $modelClass = AuthItem::class;

    /**
     * list roles
     */
    public function actionGetRoles()
    {
        $this->response->setStatusCode(200);
        return Yii::$container
                ->get('AuthItemComponent')
                ->getRoles();
    }

    /**
     * get all permissions
     */
    public function actionGetPermissions()
    {
        $this->response->setStatusCode(200);
        return Yii::$container
                ->get('AuthItemComponent')
                ->getPermissions();
    }

    /**
     * get all roles and related permissions
     */
    public function actionGetRelationships()
    {
        $this->response->setStatusCode(200);
        return Yii::$container
                ->get('AuthItemComponent')
                ->getRelationships();
    }

    /**
     * assign roles to a specified user
     */
    public function actionAssignRoles()
    {
        $bodyParams = $this->request->post();

        try {
            Yii::$container
                ->get('AuthItemComponent')
                ->assignRoles($bodyParams['user'], $bodyParams['roles']);
        } catch (Exception $e) {
            throw new HttpException($e->getCode(), $e->getMessage());
        }

        return $this->response->setStatusCode(200);
    }

    /**
     * create new role and it's relationship
     */
    public function actionCreateRelationship()
    {
        $bodyParams = $this->request->post();

        try {
            Yii::$container
                ->get('AuthItemComponent')
                ->createRelationship($bodyParams['role'], $bodyParams['permissions']);
        } catch (Exception $e) {
            throw new HttpException($e->getCode(), $e->getMessage());
        }

        return $this->response->setStatusCode(200);
    }

    /**
     * update relationship within role/permission
     */
    public function actionUpdateRelationship()
    {
        $bodyParams = $this->request->post();

        try {
            Yii::$container
                ->get('AuthItemComponent')
                ->updateRelationship($bodyParams['role'], $bodyParams['permissions']);
        } catch (Exception $e) {
            throw new HttpException($e->getCode(), $e->getMessage());
        }

        return $this->response->setStatusCode(200);
    }
}
