<?php

namespace core\models\auth;

use core\base\models\AuthCoreModel;
use Yii;

/**
 * This is the model class for table "{{%account}}".
 *
 * @property integer $id
 * @property string $username
 * @property string $sha_pass_hash
 * @property string $sessionkey
 * @property string $v
 * @property string $s
 * @property string $token_key
 * @property string $email
 * @property string $reg_mail
 * @property string $joindate
 * @property string $last_ip
 * @property string $last_attempt_ip
 * @property integer $failed_logins
 * @property integer $locked
 * @property string $lock_country
 * @property string $last_login
 * @property integer $online
 * @property integer $expansion
 * @property integer $mutetime
 * @property string $mutereason
 * @property string $muteby
 * @property integer $locale
 * @property string $os
 * @property integer $recruiter
 */
class Accounts extends AuthCoreModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%account}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['joindate', 'last_login'], 'safe'],
            [['failed_logins', 'locked', 'online', 'expansion', 'mutetime', 'locale', 'recruiter'], 'integer'],
            [['username'], 'string', 'max' => 32],
            [['sha_pass_hash'], 'string', 'max' => 40],
            [['sessionkey'], 'string', 'max' => 80],
            [['v', 's'], 'string', 'max' => 64],
            [['token_key'], 'string', 'max' => 100],
            [['email', 'reg_mail', 'mutereason'], 'string', 'max' => 255],
            [['last_ip', 'last_attempt_ip'], 'string', 'max' => 15],
            [['lock_country'], 'string', 'max' => 2],
            [['muteby'], 'string', 'max' => 50],
            [['os'], 'string', 'max' => 3],
            [['username'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'              => 'ID',
            'username'        => Yii::t('app', 'Имя учётной записи'),
            'sha_pass_hash'   => Yii::t('app', 'ХЭШ пароля'),
            'sessionkey'      => Yii::t('app', 'ключ сессии'),
            'v'               => 'V',
            's'               => 'S',
            'token_key'       => Yii::t('app', 'токен'),
            'email'           => Yii::t('app', 'email'),
            'reg_mail'        => 'registration email',
            'joindate'        => Yii::t('app', 'дата регистрации'),
            'last_ip'         => Yii::t('app', 'последний ip'),
            'last_attempt_ip' => Yii::t('app', 'последний входной ip'),
            'failed_logins'   => Yii::t('app', 'кол-во ошибок при авторизации'),
            'locked'          => Yii::t('app', 'заблокирован'),
            'lock_country'    => Yii::t('app', 'страна'),
            'last_login'      => Yii::t('app', 'дата последнего входа'),
            'online'          => Yii::t('app', 'Онлайн ?'),
            'expansion'       => Yii::t('app', 'Аддон'),
            'mutetime'        => Yii::t('app', 'Мут'),
            'mutereason'      => 'Mutereason',
            'muteby'          => Yii::t('app', 'Молчание от'),
            'locale'          => Yii::t('app', 'Язык'),
            'os'              => Yii::t('app', 'ОС'),
            'recruiter'       => Yii::t('app', 'От кого пришёл'),
        ];
    }

    /**
     * @throws \yii\base\InvalidConfigException
     * @return int|mixed|string
     */
    public static function getTotalCount()
    {
        $cache_key = 'backend.accounts.totalCount';

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
     * @throws \yii\base\InvalidConfigException
     * @return int|mixed|string
     */
    public static function getCountByDates($beginOfDay, $endOfDay)
    {
        $cache_key = "backend.accounts.countByDate_{$beginOfDay}__{$endOfDay}";

        $cache_time_total = 120 * 5;
        $cache_time_query = 60 * 5;

        $totalCount = Yii::$app->cache->get($cache_key);
        if($totalCount === false) {
            $totalCount = 0;
            foreach (Yii::$app->DBHelper->getServers() as $server) {
                self::setDb(self::getDb($server['auth_id']));
                $count = self::find()
                    ->where(['>=', 'joindate', $beginOfDay])
                    ->andWhere(['<=','joindate',$endOfDay])
                    ->cache($cache_time_query)
                    ->count();
                if($count) $totalCount += $count;
            }
            Yii::$app->cache->set($cache_key,$cache_time_total);
        }

        return $totalCount;
    }
}
