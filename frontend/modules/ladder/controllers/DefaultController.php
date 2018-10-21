<?php

namespace frontend\modules\ladder\controllers;

use Yii;

use frontend\base\controllers\SystemController;

use frontend\modules\ladder\models\LadderFormModel;

class DefaultController extends SystemController
{
    /**
     * @param $action
     * @return bool
     * @throws \yii\base\Exception
     * @throws \yii\web\BadRequestHttpException
     */
    public function beforeAction($action) {
        if(parent::beforeAction($action)) {
            $server = Yii::$app->request->get('server');
            $type = Yii::$app->request->get('type');
            if(!$server || !$type) {
                $user_server = Yii::$app->DBHelper->setDefault();
                $type = LadderFormModel::TYPE_2;
                $this->redirect(['default/index', 'server' => $user_server->realm_name, 'type' => $type]);
                return false;
            }
            return true;
        }
        return false;
    }

    /**
     * @param string $server
     * @param string $type
     * @return string|\yii\web\Response
     * @throws \yii\base\Exception
     * @throws \yii\base\InvalidConfigException
     */
    public function actionIndex($server = '',$type = '')
    {
        $data = Yii::$app->cache->get(Yii::$app->request->getUrl());

        $formModel = new LadderFormModel();
        $formModel->load(Yii::$app->request->queryParams);

        if($data === false) {
            $dataProvider = $formModel->search(Yii::$app->request->queryParams);
            $data['list'] = $dataProvider->getModels();
            $data['totalCount'] = $dataProvider->totalCount;
            $data['pageSize'] = $dataProvider->pagination->getPageSize();
            if($dataProvider->pagination->getPage() === 0) {
                $data['rank_start'] = 1;
            } else {
                if($dataProvider->pagination->getPage() - 1 > 0) {
                    $data['rank_start'] = $data['pageSize'] * ($dataProvider->pagination->getPage() - 1);
                } else {
                    $data['rank_start'] = ++$data['pageSize'];
                }
            }
            Yii::$app->cache->set(Yii::$app->request->getUrl(),$data,Yii::$app->settings->get(Yii::$app->settings::APP_MODULE_LADDER_CACHE_DURATION));
        }

        return $this->render('index', [
            'data' => $data,
            'searchModel' => $formModel,
        ]);
    }
}
