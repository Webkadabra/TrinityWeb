<?php

namespace backend\modules\file\controllers;

use alexantr\elfinder\ConnectorAction;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;

class ManagerController extends Controller
{
    /** @var string */
    public $layout = '//clear';

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow'       => true,
                        'permissions' => [Yii::$app->PermissionHelper::ACCESS_BACKEND_TO_MANAGER]
                    ]
                ]
            ]
        ];
    }

    /**
     * @return array
     */
    public function actions()
    {
        return [
            'connector' => [
                'class'   => ConnectorAction::class,
                'options' => [
                    'disabledCommands' => ['netmount'],
                    'connectOptions'   => [
                        'filter'
                    ],
                    'roots' => [
                        [
                            'driver'     => 'LocalFileSystem',
                            'path'       => Yii::getAlias('@storage/web'),
                            'URL'        => Yii::getAlias('@storageUrl'),
                            'uploadDeny' => [
                                'text/x-php', 'text/php', 'application/x-php', 'application/php'
                            ],
                        ],
                    ],
                ],
            ]
        ];
    }

    /**
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}
