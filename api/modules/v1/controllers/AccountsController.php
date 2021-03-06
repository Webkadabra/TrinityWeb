<?php

namespace api\modules\v1\controllers;

use api\modules\v1\resources\Accounts;
use yii\data\ActiveDataProvider;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\HttpHeaderAuth;
use yii\filters\auth\QueryParamAuth;
use yii\rest\ActiveController;
use yii\rest\IndexAction;
use yii\rest\OptionsAction;
use yii\rest\Serializer;
use yii\rest\ViewAction;
use yii\web\HttpException;

/**
 * Class AccountsController.
 */
class AccountsController extends ActiveController
{
    /**
     * @var string
     */
    public $modelClass = Accounts::class;
    /**
     * @var array
     */
    public $serializer = [
        'class'              => Serializer::class,
        'collectionEnvelope' => 'items',
    ];

    /**
     * @return array
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['authenticator'] = [
            'class'       => CompositeAuth::class,
            'authMethods' => [
                HttpBasicAuth::class,
                HttpBearerAuth::class,
                HttpHeaderAuth::class,
                QueryParamAuth::class,
            ],
        ];

        return $behaviors;
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'index' => [
                'class'               => IndexAction::class,
                'modelClass'          => $this->modelClass,
                'prepareDataProvider' => [$this, 'prepareDataProvider'],
            ],
            'view' => [
                'class'      => ViewAction::class,
                'modelClass' => $this->modelClass,
                'findModel'  => [$this, 'findModel'],
            ],
            'options' => [
                'class' => OptionsAction::class,
            ],
        ];
    }

    /**
     * @return ActiveDataProvider
     */
    public function prepareDataProvider()
    {
        $query = Accounts::find();
        $query->andFilterWhere(['id' => \Yii::$app->request->get('id')]);
        $query->andFilterWhere(['like', 'email', \Yii::$app->request->get('email')]);
        $query->andFilterWhere(['like', 'username', \Yii::$app->request->get('username')]);

        return new ActiveDataProvider([
            'query' => $query,
        ]);
    }

    /**
     * @param $id
     *
     * @throws HttpException
     *
     * @return array|null|\yii\db\ActiveRecord
     */
    public function findModel($id)
    {
        $model = Accounts::find()
            ->andWhere(['id' => (int) $id])
            ->one();
        if (!$model) {
            throw new HttpException(404);
        }

        return $model;
    }
}
