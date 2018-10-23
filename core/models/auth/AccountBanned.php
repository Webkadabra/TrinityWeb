<?php

namespace core\models\auth;

use Yii;

use core\base\models\AuthCoreModel;

/**
 * This is the model class for table "account_banned".
 *
 * @property integer $id Account ID
 * @property integer $bandate
 * @property integer $unbandate
 * @property string $bannedby
 * @property string $banreason
 * @property integer $active
 */
class AccountBanned extends AuthCoreModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%account_banned}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'bandate', 'bannedby', 'banreason'], 'required'],
            [['id', 'bandate', 'unbandate'], 'integer'],
            [['bannedby'], 'string', 'max' => 50],
            [['banreason'], 'string', 'max' => 255],
            [['active'], 'string', 'max' => 3],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('core', 'ID'),
            'bandate' => Yii::t('core', 'Bandate'),
            'unbandate' => Yii::t('core', 'Unbandate'),
            'bannedby' => Yii::t('core', 'Bannedby'),
            'banreason' => Yii::t('core', 'Banreason'),
            'active' => Yii::t('core', 'Active'),
        ];
    }

    /**
     * @return int|mixed|string
     * @throws \yii\base\InvalidConfigException
     */
    public static function getTotalCount()
    {
        $cache_key = 'backend.accountBanned.totalCount';

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

    /**
     * @param $beginOfDay
     * @param $endOfDay
     * @return int|mixed|string
     * @throws \yii\base\InvalidConfigException
     */
    public static function getCountByDates($beginOfDay, $endOfDay)
    {
        $cache_key = "backend.accountBanned.countByDate_{$beginOfDay}__{$endOfDay}";

        $cache_time_total = 120 * 5;
        $cache_time_query = 60 * 5;

        $totalCount = Yii::$app->cache->get($cache_key);
        if($totalCount === false) {
            $totalCount = 0;
            foreach (Yii::$app->DBHelper->getServers() as $server) {
                self::setDb(self::getDb($server['auth_id']));
                $count = self::find()
                    ->where(['>=', 'bandate', $beginOfDay])
                    ->andWhere(['<=','bandate',$endOfDay])
                    ->cache($cache_time_query)
                    ->count();
                if($count) $totalCount += $count;
            }
            Yii::$app->cache->set($cache_key,$cache_time_total);
        }
        return $totalCount;
    }

}
