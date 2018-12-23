<?php

namespace core\models;

use Yii;
use yii\behaviors\SluggableBehavior;
use yii\db\ActiveRecord;

/**
 * @property int $id [int(11)]
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
                'class'         => SluggableBehavior::class,
                'attribute'     => 'realm_name',
                'slugAttribute' => 'realm_slug',
                'immutable'     => true,
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
            'auth_id'            => Yii::t('common', 'Auth ID'),
            'realm_id'           => Yii::t('common', 'Realm ID'),
            'realm_name'         => Yii::t('common', 'Realm name'),
            'realm_slug'         => Yii::t('common', 'Realm slug'),
            'realm_address'      => Yii::t('common', 'Realm address'),
            'realm_port'         => Yii::t('common', 'Realm port'),
            'realm_build'        => Yii::t('common', 'Realm build'),
            'realm_version'      => Yii::t('common', 'Realm version'),
            'realm_localAddress' => Yii::t('common', 'Realm local address'),
        ];
    }

    public function getExpansion()
    {
        // Vanilla
        if($this->realm_build <= 6005)
            return self::EXPANSION_CLASSIC;
        // BC
        if($this->realm_build >= 6022 && $this->realm_build <= 8606)
            return self::EXPANSION_THE_BURNING_CRUSADE;
        // WOTLK
        if($this->realm_build >= 8714 && $this->realm_build <= 12340)
            return self::EXPANSION_WRATH_OF_THE_LICK_KING;
        // CATA
        if($this->realm_build >= 13164 && $this->realm_build <= 15595)
            return self::EXPANSION_CATACLYSM;
        // MOP
        if($this->realm_build >= 16016 && $this->realm_build <= 18414)
            return self::EXPANSION_MIST_OF_PANDARIA;
        // WOD
        if($this->realm_build >= 19116 && $this->realm_build <= 21742)
            return self::EXPANSION_WARLORD_OF_DRAENOR;
        // LEGION
        if($this->realm_build >= 22522 && $this->realm_build <= 26972)
            return self::EXPANSION_LEGION;
        // BFA
        if($this->realm_build >= 27355)
            return self::EXPANSION_BATTLE_FOR_AZEROTH;

        return null;
    }

    public function getVersion() {
        switch ($this->realm_build)
        {
           // Vanilla
           case 6005:
              return '1.12.2';
           case 5875:
              return '1.12.1';
           case 5595:
              return '1.12.0';
           // BC
           case 8606:
              return '2.4.3';
           case 8278:
              return '2.4.2';
           case 8125:
              return '2.4.1';
           case 8089:
              return '2.4.0';
           // WOTLK
           case 12340:
              return '3.3.5a';
           case 12213:        
              return '3.3.5';
           case 9551:       
              return '3.0.9';
           // CATA
           case 15595:
              return '4.3.4';
           case 13623:
              return '4.0.6a';
           case 13596:
              return '4.0.6';
           // MOP
           case 18414:
              return '5.4.8a';
           case 18291:
              return '5.4.8';
           case 16057:
              return '5.0.5a';
           case 16048:
              return '5.0.5';
           // WOD
           case 21742:
              return '6.2.4a';
           case 19342:
              return '6.0.3a';
           // LEGION
           case 26972:
               return '7.3.5a';
           case 24461:
              return '7.2.5a';
           // BFA
           case 28153:
           case 27980:
              return '8.0.1';
        }
           
        return null;
    }
}