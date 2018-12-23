<?php

namespace backend\modules\seo\controllers;

use backend\modules\seo\Module;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;

class MetaController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow'       => true,
                        'permissions' => [
                            Yii::$app->PermissionHelper::ACCESS_BACKEND_TO_SEO
                        ]
                    ]
                ]
            ]
        ];
    }

    public function actionIndex()
    {
        return $this->render('index', [
        ]);
    }
}