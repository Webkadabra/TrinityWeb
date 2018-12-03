<?php

namespace core\modules\forum\models\db;

use core\modules\forum\db\ActiveRecord;

/**
 * Poll answer model
 * Forum polls.
 *
 * @property int $id
 * @property string $answer
 * @property int $votes
 * @property int $poll_id
 */
class PollAnswerActiveRecord extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%poll_answer}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['answer', 'poll_id'], 'required'],
            ['answer', 'string', 'max' => 255],
            ['votes', 'default', 'value' => 0],
            ['votes', 'integer', 'min' => 0],
            ['poll_id', 'integer'],
        ];
    }
}
