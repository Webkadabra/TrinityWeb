<?php

namespace api\modules\v1\controllers;

use core\models\auth\Uptime;
use Yii;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\HttpHeaderAuth;
use yii\filters\auth\QueryParamAuth;
use yii\rest\Controller;
use yii\rest\OptionsAction;

class RealmsController extends Controller
{
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
            'options' => [
                'class' => OptionsAction::class,
            ],
        ];
    }

    /**
     * @param null $realm_id
     *
     * @throws \yii\base\InvalidConfigException
     *
     * @return array
     */
    public function actionData($realm_id = null)
    {
        $servers = Yii::$app->DBHelper->getServers();
        $result = [];
        foreach ($servers as $server) {
            Uptime::setDb(Uptime::getDb($server['auth_id']));
            $data = Uptime::find()
                ->select([
                    'MIN(realmid) as \'realmid\'',
                    'MIN(starttime) as \'starttime\'',
                    'DATE_FORMAT(FROM_UNIXTIME(`starttime`), \'%d.%M.%Y\') AS \'date_formatted\'',
                    'MAX(maxplayers) as \'maxplayers\'',
                ])
                ->groupBy(['date_formatted'])
                ->andFilterWhere(['realmid' => $realm_id])
                ->with(['realm'])
                ->orderBy(['starttime' => SORT_ASC])
                ->asArray()
                ->limit(5000)
                ->all();
            foreach ($data as $item) {
                if (!isset($result['realms'][$server['id']]['id']) || !isset($result['realms'][$server['id']]['name'])) {
                    $result['realms'][$server['id']] = [
                        'id'   => $server['id'],
                        'name' => $server['realm_name']." | build:{$server['realm_build']}",
                    ];
                }
                if ($item['realm']) {
                    $result['realms'][$server['id']]['data'][] = [
                        'date'       => $item['starttime'],
                        'maxplayers' => $item['maxplayers'],
                    ];
                }
            }
        }

        return $result;
    }
}
