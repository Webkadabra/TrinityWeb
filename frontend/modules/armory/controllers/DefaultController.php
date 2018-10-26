<?php

namespace frontend\modules\armory\controllers;

use Yii;

use frontend\base\controllers\SystemController;

use frontend\modules\armory\models\SearchForm;

class DefaultController extends SystemController
{

    /**
     * @return string|\yii\web\Response
     * @throws \yii\base\Exception
     */
    public function actionIndex()
    {
        $searchModel = new SearchForm();
        $data = $searchModel->findCharacters(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'searchResult' => $data['result'],
            'counter' => $data['counter']
        ]);
    }
}
