<?php

namespace core\models;

use Yii;
use yii\behaviors\SluggableBehavior;
use yii\db\ActiveRecord;

/**
 * @property integer $auth_id
 * @property integer $realm_id
 * @property string $realm_name
 * @property string $realm_slug
 * @property string $realm_address
 * @property string $realm_localAddress
 * @property string $realm_port
 * @property string $realm_build
 * @property string $realm_version
 * @property boolean $visible
 */
class Server extends ActiveRecord
{

    const EXPANSION_CLASSIC = 0;
    const EXPANSION_THE_BURNING_CRUSADE = 1;
    const EXPANSION_WRATH_OF_THE_LICK_KING = 2;
    const EXPANSION_CATACLYSM = 3;
    const EXPANSION_MIST_OF_PANDARIA = 4;
    const EXPANSION_WARLORD_OF_DRAENOR = 5;
    const EXPANSION_LEGION = 6;
    const EXPANSION_BATTLE_FOR_AZEROTH = 7;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%servers}}';
    }

    public function behaviors()
    {
        return [
            [
                'class' => SluggableBehavior::class,
                'attribute' => 'realm_name',
                'slugAttribute' => 'realm_slug',
                'immutable' => true,
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['auth_id', 'realm_id','realm_name','realm_address','realm_port','realm_build'], 'required'],
            [['realm_localAddress', 'realm_version', 'realm_slug'], 'string'],
            [['visible'],'boolean']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'auth_id' => Yii::t('common', 'Auth ID'),
            'realm_id' => Yii::t('common', 'Realm ID'),
            'realm_name' => Yii::t('common', 'Realm name'),
            'realm_slug' => Yii::t('common', 'Realm slug'),
            'realm_address' => Yii::t('common', 'Realm address'),
            'realm_port' => Yii::t('common', 'Realm port'),
            'realm_build' => Yii::t('common', 'Realm build'),
            'realm_version' => Yii::t('common', 'Realm version'),
            'realm_localAddress' => Yii::t('common', 'Realm local address'),
        ];
    }

    public function getExpansion() {
        //TODO calculate game expansion by build
        return self::EXPANSION_WRATH_OF_THE_LICK_KING;
    }

    public function getVersion() {
        //TODO calculate game version by build
        return '3.3.5a';
    }

}