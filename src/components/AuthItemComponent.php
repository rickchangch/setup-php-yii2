<?php

namespace app\components;

use Exception;
use Yii;
use yii\base\Component;
use yii\rbac\Permission;
use yii\rbac\Role;

class AuthItemComponent extends Component
{
    /**
     * list all roles
     *
     * @return Role[]
     */
    public function getRoles()
    {
        return Yii::$app->authManager->getRoles();
    }

    /**
     * list all permissions
     *
     * @return Permission[]
     */
    public function getPermissions()
    {
        return Yii::$app->authManager->getPermissions();
    }

    /**
     * get all roles and related permissions
     *
     * @return array
     */
    public function getRelationships()
    {
        $res = [];

        $roles = Yii::$app->authManager->getRoles();

        foreach ($roles as $idx => $role) {
            $permissions = Yii::$app->authManager->getPermissionsByRole($role->name);
            $res[] = [
                'role' => $role->name,
                'permissions' => array_keys($permissions),
            ];
        }

        return $res;
    }

    /**
     * assign roles to specified user
     *
     * @param  string $userID
     * @param  array  $roles
     */
    public function assignRoles($userID, $roles)
    {
        Yii::$app->db->transaction(function () use ($userID, $roles) {
            Yii::$app->authManager->revokeAll($userID);
            foreach ($roles as $idx => $role) {

                $roleObj = Yii::$app->authManager->getRole($role);

                if (!isset($roleObj)) {
                    throw new Exception("不存在的Role", 400);
                }

                Yii::$app->authManager->assign($roleObj, $userID);
            }
        });
    }

    /**
     * create new role and it's relationship
     *
     * @param  string $role        role name
     * @param  array  $permissions array of permission name
     */
    public function createRelationship($role, $permissions = [])
    {
        // validate
        $exsitedRole = Yii::$app->authManager->getRole($role);
        if (isset($exsitedRole)) {
            throw new Exception("欲新增角色已存在", 400);
        }

        // start TX
        Yii::$app->db->transaction(function () use ($role, $permissions) {

            // create new role object
            $role = Yii::$app->authManager->createRole($role);
            Yii::$app->authManager->add($role);

            // add new permissions
            foreach ($permissions as $idx => $permissionName) {
                Yii::$app->authManager->addChild(
                    $role,
                    Yii::$app->authManager->getPermission($permissionName)
                );
            }
        });
    }

    /**
     * update relationship within role/permission
     *
     * @param  string $role        role name
     * @param  array  $permissions array of permission name
     */
    public function updateRelationship($role, $permissions = [])
    {
        $role = Yii::$app->authManager->getRole($role);

        // start TX
        Yii::$app->db->transaction(function () use ($role, $permissions) {

            // clean role's relationship
            Yii::$app->authManager->removeChildren($role);

            // add new permissions
            foreach ($permissions as $idx => $permissionName) {
                Yii::$app->authManager->addChild(
                    $role,
                    Yii::$app->authManager->getPermission($permissionName)
                );
            }
        });
    }
}
