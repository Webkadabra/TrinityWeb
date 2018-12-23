<?php

namespace frontend\controllers;

use core\models\Article;
use core\models\ArticleAttachment;
use frontend\base\controllers\SystemController;
use Yii;
use yii\web\NotFoundHttpException;

class ArticleController extends SystemController
{
    /**
     * @param $slug
     * @throws NotFoundHttpException
     * @return string
     */
    public function actionView($slug)
    {
        $model = Article::find()->published()->andWhere(['slug' => $slug])->one();
        if (!$model) {
            throw new NotFoundHttpException;
        }

        $viewFile = $model->view ?: 'view';

        return $this->render($viewFile, ['model' => $model]);
    }

    /**
     * @param $id
     * @throws NotFoundHttpException
     * @throws \League\Flysystem\FileNotFoundException
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\web\RangeNotSatisfiableHttpException
     * @return \yii\console\Response|\yii\web\Response
     */
    public function actionAttachmentDownload($id)
    {
        $model = ArticleAttachment::findOne($id);
        if (!$model) {
            throw new NotFoundHttpException;
        }

        return Yii::$app->response->sendStreamAsFile(
            Yii::$app->fileStorage->getFilesystem()->readStream($model->path),
            $model->name
        );
    }
}