<?php

namespace core\models\chars;

use core\base\models\CharacterCoreModel;
use Yii;

/**
 * This is the model class for table "character_arena_stats".
 *
 * @property integer $guid
 * @property integer $slot
 * @property integer $matchMakerRating
 */
class CharacterArenaStats extends CharacterCoreModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'character_arena_stats';
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['guid', 'slot'], 'required'],
            [['guid', 'slot', 'matchMakerRating'], 'integer'],
        ];
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'guid'             => 'Guid',
            'slot'             => 'Slot',
            'matchMakerRating' => Yii::t('common', 'ММР'),
        ];
    }
}
