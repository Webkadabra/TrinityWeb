<?php

namespace core\modules\forum\models\db;

use core\modules\forum\db\ActiveRecord;
use core\modules\forum\models\Thread;
use core\modules\forum\models\User;
use yii\db\ActiveQuery;

/**
 * Subscription model
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $thread_id
 * @property integer $post_seen
 *
 * @property User $user
 * @property Thread $thread
 */
class SubscriptionActiveRecord extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%subscription}}';
    }

    /**
     * User relation.
     * @return ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * Thread relation.
     * @return ActiveQuery
     */
    public function getThread()
    {
        return $this->hasOne(Thread::class, ['id' => 'thread_id']);
    }
}
