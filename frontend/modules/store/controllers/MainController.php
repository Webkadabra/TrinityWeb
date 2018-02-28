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
        $isNoErrors = ShopCategory::buildBreadCrumbs();
        if($isNoErrors === false) {
            Yii::$app->session->setFlash('error',Yii::t('store','Данной категории не существует!'));
            return $this->redirect(['/store']);
        }
        $searchModel = new SearchForm();
        $data = $searchModel->findItems(Yii::$app->request->queryParams);
        
        return $this->render('index', [
            'searchModel' => $searchModel,
            'searchResult' => $data['result'],
            'counter' => $data['counter'],
            'category_discount_info' => $data['category_discount_info']
        ]);
    }
}