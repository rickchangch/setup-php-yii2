<?php

namespace app\components;

use app\models\SystemLogs;
use Exception;
use Yii;
use yii\base\Component;

class SystemLogsComponent extends Component
{

    /**
     * list system logs with user info
     *
     * @return array
     */
    public function listWithUserInfo()
    {
        return SystemLogs::find()
            ->alias('sl')
            ->select('sl.*, a.username')
            ->leftJoin('account a', 'a.id = sl.user_id')
            ->andWhere(['a.is_deleted' => 0])
            ->asArray()->all();
    }

    /**
     * record in system_logs
     *
     * @param  string $action
     *
     * @return void
     * @throws Exception
     */
    public function record($action)
    {
        $syslog = new SystemLogs();
        $syslog->user_id = Yii::$app->user->id;
        $syslog->action = $action;
        if (!$syslog->save()) {
            $errors = $syslog->getErrorSummary(true);
            throw new Exception(implode(PHP_EOL, $errors), 400);
        }
    }
}
