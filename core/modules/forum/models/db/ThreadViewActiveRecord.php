<?php

namespace core\modules\forum\models\db;

use core\modules\forum\db\ActiveRecord;

/**
 * ThreadView AR
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $thread_id
 * @property integer $new_last_seen
 * @property integer $edited_last_seen
 */
class ThreadViewActiveRecord extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%thread_view}}';
    }
}
