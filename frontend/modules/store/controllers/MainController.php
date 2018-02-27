<?php

namespace frontend\modules\store\controllers;

use Yii;
use yii\web\Controller;

use common\models\shop\ShopCategory;

class MainController extends Controller
{
    /**
     * @return string|\yii\web\Response
     */
    public function actionIndex()
    {
        ShopCategory::buildBreadCrumbs();
        return $this->render('index');
    }
}