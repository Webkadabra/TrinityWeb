<?php

namespace backend\controllers;

use backend\models\search\TimelineEventSearch;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;

/**
 * Application timeline controller
 */
class TimelineEventController extends Controller
{
    public $layout = 'common';

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions'     => ['index'],
                        'allow'       => true,
                        'permissions' => [Yii::$app->PermissionHelper::ACCESS_BACKEND_TO_TIMELINE]
                    ]
                ]
            ]
        ];
    }

    /**
     * Lists all TimelineEvent models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TimelineEventSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->sort = [
            'defaultOrder' => ['created_at' => SORT_DESC]
        ];

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }
}
