<?php

namespace core\models\auth;

use core\base\models\AuthCoreModel;
use Yii;

/**
 * This is the model class for table "{{%battlenet_accounts}}".
 *
 * @property integer $id
 * @property string $sha_pass_hash
 * @property string $email
 * @property string $joindate
 * @property string $last_ip
 * @property integer $failed_logins
 * @property integer $locked
 * @property string $lock_country
 * @property string $last_login
 * @property integer $online
 * @property integer $locale
 * @property string $os
 * @property int $LastCharacterUndelete [int(10) unsigned]
 * @property string $LoginTicket [varchar(64)]
 * @property int $LoginTicketExpiry [int(10) unsigned]
 */
class BattlenetAccout extends AuthCoreModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%battlenet_accounts}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['joindate', 'last_login'], 'safe'],
            [['failed_logins', 'locked', 'online', 'locale'], 'integer'],
            [['sha_pass_hash'], 'string', 'max' => 40],
            [['email'], 'string', 'max' => 255],
            [['last_ip'], 'string', 'max' => 15],
            [['lock_country'], 'string', 'max' => 2],
            [['os'], 'string', 'max' => 3],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'              => 'ID',
            'sha_pass_hash'   => Yii::t('app', 'ХЭШ пароля'),
            'email'           => Yii::t('app', 'email'),
            'joindate'        => Yii::t('app', 'дата регистрации'),
            'last_ip'         => Yii::t('app', 'последний ip'),
            'failed_logins'   => Yii::t('app', 'кол-во ошибок при авторизации'),
            'locked'          => Yii::t('app', 'заблокирован'),
            'lock_country'    => Yii::t('app', 'страна'),
            'last_login'      => Yii::t('app', 'дата последнего входа'),
            'online'          => Yii::t('app', 'Онлайн ?'),
            'locale'          => Yii::t('app', 'Язык'),
            'os'              => Yii::t('app', 'ОС'),
        ];
    }
}
