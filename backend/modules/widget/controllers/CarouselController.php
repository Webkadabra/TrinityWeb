<?php

namespace backend\modules\widget\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

use core\models\WidgetCarousel;
use core\traits\FormAjaxValidationTrait;

use backend\modules\widget\models\search\CarouselItemSearch;
use backend\modules\widget\models\search\CarouselSearch;

class CarouselController extends Controller
{
    use FormAjaxValidationTrait;

    /** @inheritdoc */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
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
     * @return mixed
     * @throws \yii\base\ExitException
     */
    public function actionIndex()
    {
        $widgetCarousel = new WidgetCarousel();

        $this->performAjaxValidation($widgetCarousel);

        if ($widgetCarousel->load(Yii::$app->request->post()) && $widgetCarousel->save()) {
            return $this->redirect(['update', 'id' => $widgetCarousel->id]);
        } else {
            $searchModel = new CarouselSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'model' => $widgetCarousel,
            ]);
        }
    }

    /**
     * @param integer $id
     *
     * @return mixed
     * @throws NotFoundHttpException
     * @throws \yii\base\ExitException
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
        } else {
            return $this->render('update', [
                'model' => $widgetCarousel,
                'carouselItemsProvider' => $carouselItemsProvider,
            ]);
        }
    }

    /**
     * @param integer $id
     *
     * @return mixed
     * @throws NotFoundHttpException
     * @throws \Exception
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id)
    {
        $this->findWidget($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * @param integer $id
     *
     * @return WidgetCarousel the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findWidget($id)
    {
        if (($model = WidgetCarousel::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
