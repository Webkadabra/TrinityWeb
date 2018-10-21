<?php

namespace backend\modules\content\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

use core\models\Article;
use core\models\ArticleCategory;
use core\traits\FormAjaxValidationTrait;

use backend\modules\content\models\search\ArticleSearch;

class ArticleController extends Controller
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
                        'actions' => ['index'],
                        'allow' => true,
                        'permissions' => [Yii::$app->PermissionHelper::ACCESS_BACKEND_TO_LIST_ARTICLES]
                    ],
                    [
                        'actions' => ['update'],
                        'allow' => true,
                        'permissions' => [Yii::$app->PermissionHelper::ACCESS_BACKEND_TO_UPDATE_ARTICLE]
                    ],
                    [
                        'actions' => ['create'],
                        'allow' => true,
                        'permissions' => [Yii::$app->PermissionHelper::ACCESS_BACKEND_TO_CREATE_ARTICLE]
                    ],
                    [
                        'actions' => ['delete'],
                        'allow' => true,
                        'permissions' => [Yii::$app->PermissionHelper::ACCESS_BACKEND_TO_REMOVE_ARTICLE]
                    ]
                ]
            ]
        ];
    }

    /**
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ArticleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->sort = [
            'defaultOrder' => ['published_at' => SORT_DESC],
        ];

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @return mixed
     * @throws \yii\base\ExitException
     */
    public function actionCreate()
    {
        $article = new Article();

        $this->performAjaxValidation($article);

        if ($article->load(Yii::$app->request->post()) && $article->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $article,
            'categories' => ArticleCategory::find()->active()->all(),
        ]);
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
        $article = $this->findModel($id);

        $this->performAjaxValidation($article);

        if ($article->load(Yii::$app->request->post())) {
            if($article->save()) {
                return $this->redirect(['index']);
            }
        } else {
            return $this->render('update', [
                'model' => $article,
                'categories' => ArticleCategory::find()->active()->all(),
            ]);
        }
    }

    /**
     * @param integer $id
     *
     * @return mixed
     * @throws NotFoundHttpException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * @param integer $id
     *
     * @return Article the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Article::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
