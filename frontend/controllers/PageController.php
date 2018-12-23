<?php

namespace frontend\controllers;

use core\models\Page;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class PageController extends Controller
{
    /**
     * @param $slug
     * @throws NotFoundHttpException
     * @return string
     */
    public function actionView($slug)
    {
        $model = Page::find()->where(['slug' => $slug])->published()->one();

        if (!$model) {
            throw new NotFoundHttpException(Yii::t('frontend', 'Page not found'));
        }

        $viewFile = $model->view ?: 'view';

        return $this->render($viewFile, ['model' => $model]);
    }
}
