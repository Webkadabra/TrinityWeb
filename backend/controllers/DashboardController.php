<?php

namespace backend\controllers;

use core\models\auth\AccountAccess;
use core\models\auth\AccountBanned;
use core\models\auth\Accounts;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;

/**
 * Dashboard controller.
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
                        'actions'     => ['index'],
                        'allow'       => true,
                        'permissions' => [Yii::$app->PermissionHelper::ACCESS_BACKEND_TO_DASHBOARD],
                    ],
                ],
            ],
        ];
    }

    /**
     * @throws \yii\base\InvalidConfigException
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $beginOfDay = strtotime('midnight', time());
        $endOfDay = strtotime('tomorrow', $beginOfDay) - 1;

        $bannedAccounts_total_count = AccountBanned::getTotalCount();
        $registeredAccounts_total_count = Accounts::getTotalCount();

        $bannedAccounts_today_count = AccountBanned::getCountByDates($beginOfDay, $endOfDay);
        $registeredAccounts_today_count = Accounts::getCountByDates($beginOfDay, $endOfDay);

        $gms_total_count = AccountAccess::getTotalCount();

        return $this->render('index', [
            'bannedAccounts_total_count'     => $bannedAccounts_total_count,
            'bannedAccounts_today_count'     => $bannedAccounts_today_count,
            'registeredAccounts_total_count' => $registeredAccounts_total_count,
            'registeredAccounts_today_count' => $registeredAccounts_today_count,
            'gms_total_count'                => $gms_total_count,
        ]);
    }
}
