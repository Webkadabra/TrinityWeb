<?php

namespace core\base\models;

use Yii;
use yii\db\ActiveRecord;

class CharacterCoreModel extends ActiveRecord
{
    const COMPONENT_PREFIX = 'char_';

    private static $_db;

    /**
     * Get connection to DB by authID and realmID or GET request DATA
     * @param null $auth_id
     * @param null $realm_id
     * @throws \yii\base\Exception
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\web\NotFoundHttpException
     * @return yii\db\Connection
     * @todo Problem with equal named realms in table *servers*
     */
    public static function getDb($auth_id = null, $realm_id = null) {
        if($auth_id === null || $realm_id === null) {
            if (isset(self::$_db)) {
                return self::$_db;
            }
            $server_name = null;
            if($server_name = Yii::$app->request->get('server')) {
                $server = Yii::$app->DBHelper->getServerByName($server_name);
            } else {
                if(Yii::$app->user->isGuest) {
                    $server = Yii::$app->DBHelper->setDefault();
                } else {
                    $auth_id = Yii::$app->user->identity->auth_id;
                    $realm_id = Yii::$app->user->identity->realm_id;
                    if(empty($auth_id) || empty($realm_id)) {
                        $server = Yii::$app->DBHelper->setDefault();
                    } else {
                        $server = Yii::$app->DBHelper->getServer($auth_id,$realm_id);
                    }
                }
            }

            $auth_id = $server->auth_id;
            $realm_id = $server->realm_id;
        }

        return Yii::$app->DBHelper->getConnection(
            null,
            self::buildComponentName($auth_id,$realm_id)
        );
    }

    public static function buildComponentName($auth_id, $realm_id) {
        return self::COMPONENT_PREFIX . "{$auth_id}_{$realm_id}";
    }

    public static function setDb($db) {
        self::$_db = $db;
    }
}