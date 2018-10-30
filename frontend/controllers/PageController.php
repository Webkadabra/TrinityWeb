<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

use core\models\Page;

class PageController extends Controller
{
    /**
     * @param $slug
     * @return string
     * @throws NotFoundHttpException
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
