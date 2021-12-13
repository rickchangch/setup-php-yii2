<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;

/**
 * EntryController
 */
class EntryController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['access'] = [
            'class' => AccessControl::class,
            'only' => ['index'],
            'rules' => [
                [
                    'allow' => true,
                    'actions' => ['index'],
                ],
            ],
        ];
        return $behaviors;
    }

    /**
     * index
     */
    public function actionIndex()
    {
        if (!Yii::$app->user->isGuest) {
            $this->redirect('home', 302);
        }

        return $this->render('index');
    }
}
