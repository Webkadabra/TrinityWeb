<?php

namespace core\modules\forum\models\db;

use core\modules\forum\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

/**
 * PostThumb model
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $post_id
 * @property integer $created_at
 * @property integer $updated_at
 */
class PostThumbActiveRecord extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%post_thumb}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [TimestampBehavior::class];
    }
}
