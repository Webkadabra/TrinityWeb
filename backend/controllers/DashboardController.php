<?php

namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;

use core\models\auth\AccountBanned;
use core\models\auth\Accounts;
use core\models\auth\AccountAccess;

/**
 * Dashboard controller
 */
class DashboardController extends Controller
{
    public $layout = 'common';

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'permissions' => [Yii::$app->PermissionHelper::ACCESS_BACKEND_TO_DASHBOARD]
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
        $beginOfDay = strtotime("midnight", time());
        $endOfDay   = strtotime("tomorrow", $beginOfDay) - 1;

        // TODO
        /*$bannedAccounts_total_count = AccountBanned::find()->cache(60*5)->count();
        $registeredAccounts_total_count = Accounts::find()->cache(60*5)->count();*/
        $bannedAccounts_total_count = 0;
        $registeredAccounts_total_count = 0;

        // TODO
        /*$bannedAccounts_today_count = AccountBanned::find()->where(['>=', 'bandate', $beginOfDay])->andWhere(['<=','bandate',$endOfDay])->cache(60*5)->count();
        $registeredAccounts_today_count = Accounts::find()->where(['>=', 'joindate', $beginOfDay])->andWhere(['<=','joindate',$endOfDay])->cache(60*5)->count();*/
        $bannedAccounts_today_count = 0;
        $registeredAccounts_today_count = 0;

        // TODO
        //$gms_total_count = AccountAccess::getTotalCount();
        $gms_total_count = 0;

        return $this->render('index',[
            'bannedAccounts_total_count' => $bannedAccounts_total_count,
            'bannedAccounts_today_count' => $bannedAccounts_today_count,
            'registeredAccounts_total_count' => $registeredAccounts_total_count,
            'registeredAccounts_today_count' => $registeredAccounts_today_count,
            'gms_total_count' => $gms_total_count
        ]);
    }
}
