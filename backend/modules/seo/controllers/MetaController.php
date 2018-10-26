<?php

namespace backend\modules\system\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;

use backend\modules\rbac\models\Route;

class MetaController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'permissions' => [
                            Yii::$app->PermissionHelper::ACCESS_BACKEND_TO_SETTINGS
                        ]
                    ]
                ]
            ]
        ];
    }

    public function actionIndex()
    {
        $routeModel = new Route();
        //pre($routeModel->getAppRoutes());
        return $this->render('index', [
        ]);
    }

}