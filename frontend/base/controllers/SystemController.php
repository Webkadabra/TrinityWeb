<?php

namespace frontend\base\controllers;

use Yii;
use yii\web\Controller;

class SystemController extends Controller
{

    public function init()
    {
        if(!Yii::$app->TrinityWeb::isAppInstalled()) {
            Yii::$app->response->redirect(['/install/step/prerequisites']);
            Yii::$app->end();
        }
        parent::init();
    }

    public function beforeAction($action)
    {
        return parent::beforeAction($action);
    }
}
