<?php

namespace core\modules\forum\models\db;

use core\modules\forum\db\ActiveRecord;
use yii\db\ActiveQuery;

/**
 * Mod AR
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $forum_id
 */
class ModActiveRecord extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%moderator}}';
    }

    /**
     * Forum relation.
     * @return ActiveQuery
     */
    public function getForum()
    {
        return $this->hasOne(static::class, ['id' => 'forum_id']);
    }
}
