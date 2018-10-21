<?php

namespace core\models\chars;

use Yii;

use core\base\models\CharacterCoreModel;

/**
 * This is the model class for table "arena_team_member".
 *
 * @property integer $arenaTeamId
 * @property integer $guid
 * @property integer $weekGames
 * @property integer $weekWins
 * @property integer $seasonGames
 * @property integer $seasonWins
 * @property integer $personalRating
 *
 * @property Characters $character
 * @property ArenaTeam $team
 *
 */
class ArenaTeamMember extends CharacterCoreModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'arena_team_member';
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['arenaTeamId', 'guid'], 'required'],
            [['arenaTeamId', 'guid', 'weekGames', 'weekWins', 'seasonGames', 'seasonWins', 'personalRating'], 'integer'],
        ];
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'arenaTeamId' => 'Arena Team ID',
            'guid' => 'Guid',
            'weekGames' => Yii::t('common', 'Недельных игр'),
            'weekWins' => Yii::t('common', 'Недельных побед'),
            'seasonGames' => Yii::t('common', 'Игр в сезоне'),
            'seasonWins' => Yii::t('common', 'Побед в сезоне'),
            'personalRating' => Yii::t('common', 'личный рейтинг'),
        ];
    }

    public function getCharacter() {
        return $this->hasOne(Characters::class, ['guid' => 'guid']);
    }

    public function getTeam() {
        return $this->hasOne(ArenaTeam::class,['arenaTeamId' => 'arenaTeamId']);
    }
    
}
