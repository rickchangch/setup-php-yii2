<?php

namespace app\controllers\api\v1;

use app\models\SystemLogs;
use Yii;
use yii\rest\ActiveController;

/**
 * SystemLogsController implements the CRUD actions for system_logs model.
 */
class SystemLogsController extends ActiveController
{
    /**
     * {@inheritDoc}
     * @var SystemLogs
     */
    public $modelClass = SystemLogs::class;

    /**
     * list system logs with user info
     */
    public function actionListWithUserInfo()
    {
        return Yii::$container
            ->get('SystemLogsComponent')
            ->listWithUserInfo();
    }
}
