<?php

namespace backend\modules\system\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;

use Probe\ProviderFactory;

class InformationController extends Controller
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
                            Yii::$app->PermissionHelper::ACCESS_BACKEND_TO_INFORMATION
                        ]
                    ]
                ]
            ]
        ];
    }

    public $layout = '@backend/views/layouts/common';

    public function actionIndex()
    {
        $provider = ProviderFactory::create();
        if ($provider) {
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                if ($key = Yii::$app->request->get('data')) {
                    switch ($key) {
                        case 'cpu_usage':
                            return $provider->getCpuUsage();
                            break;
                        case 'memory_usage':
                            return ($provider->getTotalMem() - $provider->getFreeMem()) / $provider->getTotalMem();
                            break;
                    }
                }
            } else {
                return $this->render('index', ['provider' => $provider]);
            }
        }

        return $this->render('fail');
    }
}
