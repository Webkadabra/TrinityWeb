<?php

namespace core\base\models;

use core\models\Server;
use Yii;
use yii\db\ActiveRecord;
use Yii\db\Connection;

class AuthCoreModel extends ActiveRecord
{
    const COMPONENT_PREFIX = 'auth_';

    private static $_db;

    /**
     * Get connection to DB by authID
     * @param null $auth_id
     * @throws \yii\base\InvalidConfigException
     * @return Connection
     */
    public static function getDb($auth_id = null) {
        if($auth_id === null) {
            if (isset(self::$_db)) {
                return self::$_db;
            }
            $server = Server::find()->one();

            return Yii::$app->DBHelper->getConnection(self::COMPONENT_PREFIX,$server->auth_id);
        }

        return Yii::$app->DBHelper->getConnection(self::COMPONENT_PREFIX,$auth_id);
    }

    public static function setDb($db) {
        self::$_db = $db;
    }
}