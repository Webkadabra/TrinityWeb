<?php

namespace backend\modules\system\models;

use core\models\User;
use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "system_log".
 *
 * @property integer $id
 * @property integer $level
 * @property string  $category
 * @property integer $log_time
 * @property string  $prefix
 * @property string  $ip
 * @property string $message
 * @property integer $model
 * @property integer $user_id
 * @property int $time [int(10) unsigned]
 * @property int $realm [int(10) unsigned]
 * @property string $type [varchar(250)]
 * @property string $string
 *
 * @property User $user
 *
 */
class SystemLog extends ActiveRecord
{
    const CATEGORY_NOTIFICATION = 'notification';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%logs}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['level', 'log_time','ip','model','user_id'], 'integer'],
            [['log_time'], 'required'],
            [['prefix','message'], 'string'],
            [['category'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'       => Yii::t('backend', 'ID'),
            'level'    => Yii::t('backend', 'Level'),
            'category' => Yii::t('backend', 'Category'),
            'log_time' => Yii::t('backend', 'Log Time'),
            'prefix'   => Yii::t('backend', 'Prefix'),
            'ip'       => Yii::t('backend', 'Ip'),
            'message'  => Yii::t('backend', 'Message'),
            'model'    => Yii::t('backend', 'Model'),
            'user_id'  => Yii::t('backend', 'User'),
        ];
    }

    public function getUser() {
        return $this->hasOne(User::class,['id' => 'user_id']);
    }
}
