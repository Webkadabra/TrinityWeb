<?php

namespace frontend\modules\ladder\controllers;

use core\models\chars\ArenaTeam;
use frontend\base\controllers\SystemController;
use Yii;

class TeamController extends SystemController
{
    /**
     * @param $action
     * @throws \yii\web\NotFoundHttpException
     * @return bool
     */
    public function beforeAction($action) {
        if(parent::beforeAction($action)) {
            Yii::$app->view->params['breadcrumbs'][] = ['label' => Yii::$app->DBHelper->getServerFromGet()->realm_name];

            return true;
        }

        return false;
    }

    /**
     * @param string $server
     * @param string $teamId
     * @throws \yii\base\InvalidConfigException
     * @return string|\yii\web\Response
     */
    public function actionIndex($server = '',$teamId = '')
    {
        $data = Yii::$app->cache->get(Yii::$app->request->getUrl());
        if($data === false) {
            $data = ArenaTeam::find()->where(['arenaTeamId' => $teamId])->with([
                'members.character.arenaStats'
            ])->one();
            Yii::$app->params['breadcrumbs'][] = ['label' => $data['name']];
            Yii::$app->cache->set(Yii::$app->request->getUrl(),$data,Yii::$app->settings->get(Yii::$app->settings::APP_MODULE_LADDER_CACHE_DURATION));
        }

        return $this->render('index',[
            'data' => $data,
        ]);
    }
}