<?php

namespace core\models\auth;

use Yii;

use core\base\models\AuthCoreModel;

/**
 * This is the model class for table "{{%account_access}}".
 *
 * @property integer $id Account ID
 * @property integer $gmlevel
 * @property integer $RealmID
 *
 * @property integer $totalCount
 */
class AccountAccess extends AuthCoreModel
{

    const GLOBAL = -1;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%account_access}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'gmlevel', 'RealmID'], 'required'],
            [['id', 'RealmID'], 'integer'],
            [['gmlevel'], 'string', 'max' => 3],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('core', 'ID'),
            'gmlevel' => Yii::t('core', 'Gmlevel'),
            'RealmID' => Yii::t('core', 'Realm ID'),
        ];
    }

    public static function getTotalCount()
    {
        $cache_key = 'backend.accountAccess.totalCount';

        $cache_time_total = 120 * 5;
        $cache_time_query = 60 * 5;

        $totalCount = Yii::$app->cache->get($cache_key);
        if($totalCount === false) {
            $totalCount = 0;
            foreach (Yii::$app->DBHelper->getServers() as $server) {
                self::setDb(self::getDb($server['auth_id']));
                $count = self::find()->cache($cache_time_query)->count();
                if($count) $totalCount += $count;
            }
            Yii::$app->cache->set($cache_key,$cache_time_total);
        }
        return $totalCount;
    }

}
