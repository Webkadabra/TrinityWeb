<?php

namespace frontend\modules\store\controllers;

use Yii;
use yii\web\Controller;

class MainController extends Controller
{
    /**
     * @return string|\yii\web\Response
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}