<?php

namespace core\models\chars;

use core\base\models\CharacterCoreModel;

/**
 * This is the model class for table "guild_member".
 *
 * @property integer $guildid
 * @property integer $guid
 * @property integer $rank
 * @property string $pnote
 * @property string $offnote
 *
 * @property GuildMember $guild
 */
class GuildMember extends CharacterCoreModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'guild_member';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['guildid', 'guid', 'rank'], 'required'],
            [['guildid', 'guid', 'rank'], 'integer'],
            [['pnote', 'offnote'], 'string', 'max' => 31],
            [['guid'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'guildid' => 'Guildid',
            'guid' => 'Guid',
            'rank' => 'Rank',
            'pnote' => 'Pnote',
            'offnote' => 'Offnote',
        ];
    }
    /**
    * Связь для получения объекта содержащего данные о гильдии для участника
    * @return \yii\db\ActiveQuery
    */
    public function getGuild() {
        return $this->hasOne(Guild::class,['guildid' => 'guildid']);
    }

}
