<?php

namespace backend\modules\system\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;

use backend\modules\system\models\SettingsModel;

class SettingsController extends Controller
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
        $model = new SettingsModel();
        if($post = YIi::$app->request->post()) {
            if($model->save($post)) {
                Yii::$app->session->setFlash('alert', [
                    'body' => Yii::t('backend', 'Settings was successfully saved'),
                    'options' => ['class' => 'alert alert-success'],
                ]);
            }
            return $this->refresh();
        }
        return $this->render('index', ['model' => $model]);
    }

}