<?php

namespace backend\modules\system\controllers;

use backend\modules\system\models\AuthDatabases;
use backend\modules\system\models\CharDatabases;
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
        $auth_errorMsg = [];
        $char_errorMsg = [];
        $model = new SettingsModel();

        $authFormName = (new AuthDatabases)->formName();
        $charFormName = (new CharDatabases)->formName();

        if(
            $model->save(Yii::$app->request->post()) &&
            $model->loadAuthDbs(Yii::$app->request->post($authFormName)) &&
            $model->loadCharDbs(Yii::$app->request->post($charFormName))
        ) {

            $auth_errorMsg = $model->saveAuthConnections();
            $char_errorMsg = $model->saveCharConnections();

            if(empty($auth_errorMsg) && empty($char_errorMsg)) {

                Yii::$app->TrinityWeb::executeCommand('app/sync-servers --interactive=0');
                Yii::$app->TrinityWeb::executeCommand('cache/flush-all --interactive=0');
                Yii::$app->session->setFlash('alert', [
                    'body' => Yii::t('backend', 'Settings was successfully saved'),
                    'options' => ['class' => 'alert alert-success'],
                ]);

                return $this->refresh();

            }
        }
        return $this->render('index', [
            'model' => $model,
            'auth_errorMsg' => $auth_errorMsg,
            'char_errorMsg' => $char_errorMsg
        ]);
    }

}