<?php

namespace backend\modules\widget\controllers;

use core\models\WidgetCarousel;
use core\models\WidgetCarouselItem;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;

class CarouselItemController extends Controller
{
    /** @inheritdoc */
    public function getViewPath()
    {
        return $this->module->getViewPath() . DIRECTORY_SEPARATOR . 'carousel/item';
    }

    /** @inheritdoc */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class'   => VerbFilter::class,
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow'       => true,
                        'permissions' => [
                            Yii::$app->PermissionHelper::ACCESS_BACKEND_TO_REMOVE_CAROUSEL_ITEM,
                            Yii::$app->PermissionHelper::ACCESS_BACKEND_TO_UPDATE_CAROUSEL_ITEM,
                            Yii::$app->PermissionHelper::ACCESS_BACKEND_TO_CREATE_CAROUSEL_ITEM
                        ]
                    ]
                ]
            ]
        ];
    }

    /**
     * @param $carousel_id
     *
     * @throws HttpException
     * @return mixed
     */
    public function actionCreate($carousel_id)
    {
        $model = new WidgetCarouselItem();
        $carousel = WidgetCarousel::findOne($carousel_id);
        if (!$carousel) {
            throw new HttpException(400);
        }

        $model->carousel_id = $carousel->id;
        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                Yii::$app->getSession()->setFlash('alert', ['options' => ['class' => 'alert-success'], 'body' => Yii::t('backend', 'Carousel slide was successfully saved')]);

                return $this->redirect(['/widget/carousel/update', 'id' => $model->carousel_id]);
            }
        }

        return $this->render('create', [
            'model'    => $model,
            'carousel' => $carousel,
        ]);
    }

    /**
     * @param integer $id
     *
     * @throws NotFoundHttpException
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findItem($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->getSession()->setFlash('alert', ['options' => ['class' => 'alert-success'], 'body' => Yii::t('backend', 'Carousel slide was successfully saved')]);

            return $this->redirect(['/widget/carousel/update', 'id' => $model->carousel_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * @param integer $id
     *
     * @throws NotFoundHttpException
     * @throws \Exception
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     * @return mixed
     */
    public function actionDelete($id)
    {
        ($model = $this->findItem($id))->delete();

        return $this->redirect(['/widget/carousel/update', 'id' => $model->carousel_id]);
    }

    /**
     * @param integer $id
     *
     * @throws NotFoundHttpException if the model cannot be found
     * @return WidgetCarouselItem the loaded model
     */
    protected function findItem($id)
    {
        if (($model = WidgetCarouselItem::findOne($id)) !== null) {
            return $model;
        }  
            throw new NotFoundHttpException('The requested page does not exist.');
    }
}
