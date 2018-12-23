<?php

namespace backend\modules\content\controllers;

use backend\modules\content\models\search\PageSearch;
use core\models\Page;
use core\traits\FormAjaxValidationTrait;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class PageController extends Controller
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
                        'actions'     => ['index'],
                        'allow'       => true,
                        'permissions' => [Yii::$app->PermissionHelper::ACCESS_BACKEND_TO_LIST_PAGES]
                    ],
                    [
                        'actions'     => ['create'],
                        'allow'       => true,
                        'permissions' => [Yii::$app->PermissionHelper::ACCESS_BACKEND_TO_CREATE_PAGE]
                    ],
                    [
                        'actions'     => ['update'],
                        'allow'       => true,
                        'permissions' => [Yii::$app->PermissionHelper::ACCESS_BACKEND_TO_UPDATE_PAGE]
                    ],
                    [
                        'actions'     => ['delete'],
                        'allow'       => true,
                        'permissions' => [Yii::$app->PermissionHelper::ACCESS_BACKEND_TO_REMOVE_PAGE]
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
        $page = new Page();

        $this->performAjaxValidation($page);

        if ($page->load(Yii::$app->request->post()) && $page->save()) {
            return $this->redirect(['index']);
        }  
            $searchModel = new PageSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            return $this->render('index', [
                'searchModel'  => $searchModel,
                'dataProvider' => $dataProvider,
                'model'        => $page,
            ]);
    }

    /**
     * @return mixed
     */
    public function actionCreate()
    {
        $page = new Page();

        $this->performAjaxValidation($page);

        if ($page->load(Yii::$app->request->post()) && $page->save()) {
            return $this->redirect(['index']);
        }
  
            return $this->render('create', [
                'model' => $page,
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
        $page = $this->findModel($id);

        $this->performAjaxValidation($page);

        if ($page->load(Yii::$app->request->post()) && $page->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $page,
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
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * @param integer $id
     *
     * @throws NotFoundHttpException if the model cannot be found
     * @return Page the loaded model
     */
    protected function findModel($id)
    {
        if (($model = Page::findOne($id)) !== null) {
            return $model;
        }  
            throw new NotFoundHttpException('The requested page does not exist.');
    }
}
