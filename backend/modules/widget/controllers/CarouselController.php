<?php

namespace backend\modules\widget\controllers;

use backend\modules\widget\models\search\CarouselItemSearch;
use backend\modules\widget\models\search\CarouselSearch;
use core\models\WidgetCarousel;
use core\traits\FormAjaxValidationTrait;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class CarouselController extends Controller
{
    use FormAjaxValidationTrait;

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
                            Yii::$app->PermissionHelper::ACCESS_BACKEND_TO_LIST_CAROUSELS,
                            Yii::$app->PermissionHelper::ACCESS_BACKEND_TO_REMOVE_CAROUSEL,
                            Yii::$app->PermissionHelper::ACCESS_BACKEND_TO_UPDATE_CAROUSEL
                        ]
                    ]
                ]
            ]
        ];
    }

    /**
     * @throws \yii\base\ExitException
     * @return mixed
     */
    public function actionIndex()
    {
        $widgetCarousel = new WidgetCarousel();

        $this->performAjaxValidation($widgetCarousel);

        if ($widgetCarousel->load(Yii::$app->request->post()) && $widgetCarousel->save()) {
            return $this->redirect(['update', 'id' => $widgetCarousel->id]);
        }  
            $searchModel = new CarouselSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            return $this->render('index', [
                'searchModel'  => $searchModel,
                'dataProvider' => $dataProvider,
                'model'        => $widgetCarousel,
            ]);
    }

    /**
     * @param integer $id
     *
     * @throws NotFoundHttpException
     * @throws \yii\base\ExitException
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $widgetCarousel = $this->findWidget($id);

        $this->performAjaxValidation($widgetCarousel);

        $searchModel = new CarouselItemSearch();
        $carouselItemsProvider = $searchModel->search([]);
        $carouselItemsProvider->query->andWhere(['carousel_id' => $widgetCarousel->id]);

        if ($widgetCarousel->load(Yii::$app->request->post()) && $widgetCarousel->save()) {
            return $this->redirect(['index']);
        }
  
            return $this->render('update', [
                'model'                 => $widgetCarousel,
                'carouselItemsProvider' => $carouselItemsProvider,
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
        $this->findWidget($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * @param integer $id
     *
     * @throws NotFoundHttpException if the model cannot be found
     * @return WidgetCarousel the loaded model
     */
    protected function findWidget($id)
    {
        if (($model = WidgetCarousel::findOne($id)) !== null) {
            return $model;
        }  
            throw new NotFoundHttpException('The requested page does not exist.');
    }
}
