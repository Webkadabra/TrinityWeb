<?php

namespace frontend\controllers;

use Yii;
use yii\web\ErrorAction;

use frontend\base\controllers\SystemController;

use frontend\models\search\ArticleSearch;

class MainController extends SystemController
{

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => ErrorAction::class
            ],
            'set-locale' => [
                'class' => \core\actions\SetLocaleAction::class,
                'locales' => Yii::$app->i18nHelper::getLocales()
            ]
        ];
    }

    /**
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ArticleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->sort = [
            'defaultOrder' => ['created_at' => SORT_DESC]
        ];
        return $this->render('index', [
            'dataProvider' => $dataProvider
        ]);
    }
}
