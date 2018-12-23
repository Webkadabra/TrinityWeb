<?php

namespace frontend\modules\armory\controllers;

use frontend\base\controllers\SystemController;
use frontend\modules\armory\models\SearchForm;
use Yii;

class DefaultController extends SystemController
{
    /**
     * @throws \yii\base\Exception
     * @return string|\yii\web\Response
     */
    public function actionIndex()
    {
        $searchModel = new SearchForm();
        $data = $searchModel->findCharacters(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel'  => $searchModel,
            'searchResult' => $data['result'],
            'counter'      => $data['counter']
        ]);
    }
}
