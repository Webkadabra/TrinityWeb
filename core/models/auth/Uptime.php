<?php

namespace core\models\auth;

use core\base\models\AuthCoreModel;
use Yii;

/**
 * This is the model class for table "{{%uptime}}".
 *
 * @property integer $realmid
 * @property integer $starttime
 * @property integer $uptime
 * @property integer $maxplayers
 * @property string $revision
 *
 * @property Realmlist $realm
 */
class Uptime extends AuthCoreModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%uptime}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['realmid', 'starttime'], 'required'],
            [['realmid', 'starttime', 'uptime', 'maxplayers'], 'integer'],
            [['revision'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'realmid'    => Yii::t('core', 'Realmid'),
            'starttime'  => Yii::t('core', 'Starttime'),
            'uptime'     => Yii::t('core', 'Uptime'),
            'maxplayers' => Yii::t('core', 'Maxplayers'),
            'revision'   => Yii::t('core', 'Revision'),
        ];
    }

    public function getRealm() {
        return $this->hasOne(Realmlist::class, ['id' => 'realmid']);
    }
}
