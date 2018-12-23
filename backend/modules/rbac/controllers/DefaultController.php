<?php

namespace backend\modules\rbac\controllers;

use Yii;

/**
 * DefaultController
 */
class DefaultController extends \yii\web\Controller
{
    /**
     * Action index
     * @param mixed $page
     */
    public function actionIndex($page = 'README.md')
    {
        if (strpos($page, '.png') !== false) {
            $file = Yii::getAlias("@backend\modules\rbac/admin/{$page}");

            return Yii::$app->getResponse()->sendFile($file);
        }

        return $this->render('index', ['page' => $page]);
    }
}
