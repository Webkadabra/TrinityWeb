<?php

namespace backend\modules\content\controllers;

use backend\modules\content\models\search\ArticleCategorySearch;
use core\models\ArticleCategory;
use core\traits\FormAjaxValidationTrait;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class CategoryController extends Controller
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
                        'permissions' => [Yii::$app->PermissionHelper::ACCESS_BACKEND_TO_CATEGORIES]
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
        $category = new ArticleCategory();

        $this->performAjaxValidation($category);

        if ($category->load(Yii::$app->request->post()) && $category->save()) {
            return $this->redirect(['index']);
        }  
            $searchModel = new ArticleCategorySearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            $categories = ArticleCategory::find()->noParents()->all();
            $categories = ArrayHelper::map($categories, 'id', 'title');

            return $this->render('index', [
                'searchModel'  => $searchModel,
                'dataProvider' => $dataProvider,
                'model'        => $category,
                'categories'   => $categories,
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
        $category = $this->findModel($id);

        $this->performAjaxValidation($category);

        if ($category->load(Yii::$app->request->post()) && $category->save()) {
            return $this->redirect(['index']);
        }  
            $categories = ArticleCategory::find()->noParents()->andWhere(['not', ['id' => $id]])->all();
            $categories = ArrayHelper::map($categories, 'id', 'title');

            return $this->render('update', [
                'model'      => $category,
                'categories' => $categories,
            ]);
    }

    /**
     * @param integer $id
     *
     * @throws NotFoundHttpException
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
     * @return ArticleCategory the loaded model
     */
    protected function findModel($id)
    {
        if (($model = ArticleCategory::findOne($id)) !== null) {
            return $model;
        }  
            throw new NotFoundHttpException('The requested page does not exist.');
    }
}
