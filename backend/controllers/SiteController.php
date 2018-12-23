<?php

namespace backend\controllers;

use Yii;

/**
 * Site controller
 */
class SiteController extends \yii\web\Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::class,
                'rules' => [
                    [
                        'allow'   => true,
                        'roles'   => ['?', '@'],
                        'actions' => ['error'],
                    ]
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function beforeAction($action)
    {
        $this->layout = Yii::$app->user->isGuest || !Yii::$app->user->can(Yii::$app->PermissionHelper::ACCESS_TO_BACKEND) ? 'base' : 'common';

        return parent::beforeAction($action);
    }
}
