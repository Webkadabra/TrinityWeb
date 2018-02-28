<?php

namespace frontend\modules\store\controllers;

use Yii;
use yii\web\Controller;

use common\models\shop\ShopCategory;
use frontend\modules\store\models\SearchForm;

class MainController extends Controller
{
    /**
     * @return string|\yii\web\Response
     */
    public function actionIndex()
    {
        ShopCategory::buildBreadCrumbs();
        
        $searchModel = new SearchForm();
        $data = $searchModel->findItems(Yii::$app->request->queryParams);
        
        return $this->render('index', [
            'searchModel' => $searchModel,
            'searchResult' => $data['result'],
            'counter' => $data['counter']
        ]);
    }
}