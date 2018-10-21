<?php

namespace core\models\chars;

use Yii;

use core\base\models\CharacterCoreModel;

/**
 * This is the model class for table "arena_team".
 *
 * @property integer $arenaTeamId
 * @property string $name
 * @property integer $captainGuid
 * @property integer $type
 * @property integer $rating
 * @property integer $seasonGames
 * @property integer $seasonWins
 * @property integer $weekGames
 * @property integer $weekWins
 * @property integer $rank
 * @property integer $backgroundColor
 * @property integer $emblemStyle
 * @property integer $emblemColor
 * @property integer $borderStyle
 * @property integer $borderColor
 *
 * @property ArenaTeamMember[] $members
 *
 */
class ArenaTeam extends CharacterCoreModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'arena_team';
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['arenaTeamId', 'name'], 'required'],
            [['arenaTeamId', 'captainGuid', 'type', 'rating', 'seasonGames', 'seasonWins', 'weekGames', 'weekWins', 'rank', 'backgroundColor', 'emblemStyle', 'emblemColor', 'borderStyle', 'borderColor'], 'integer'],
            [['name'], 'string', 'max' => 24],
        ];
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'arenaTeamId' => 'Arena Team ID',
            'name' => Yii::t('common', 'Название'),
            'captainGuid' => 'Captain Guid',
            'type' => Yii::t('common', 'Тип'),
            'rating' => Yii::t('common', 'Рейтинг'),
            'seasonGames' => Yii::t('common', 'Игр в сезоне'),
            'seasonWins' => Yii::t('common', 'Побед в сезоне'),
            'weekGames' => Yii::t('common', 'Недельных игр'),
            'weekWins' => Yii::t('common', 'Недельных побед'),
            'rank' => Yii::t('common', 'Ранг'),
            'backgroundColor' => 'Background Color',
            'emblemStyle' => 'Emblem Style',
            'emblemColor' => 'Emblem Color',
            'borderStyle' => 'Border Style',
            'borderColor' => 'Border Color',
        ];
    }
    /**
    * Связь для получения объектов содержащих данные о участниках команды
    * @return \yii\db\ActiveQuery
    */
    public function getMembers() {
        return $this->hasMany(ArenaTeamMember::class, ['arenaTeamId' => 'arenaTeamId']);
    }
}
