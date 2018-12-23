<?php

namespace core\modules\forum\models\db;

use core\modules\forum\db\ActiveRecord;
use core\modules\forum\models\Message;
use core\modules\forum\models\User;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;

/**
 * MessageReceiver AR
 *
 * @property integer $id
 * @property integer $message_id
 * @property integer $receiver_id
 * @property integer $receiver_status
 * @property integer $updated_at
 * @property integer $created_at
 */
class MessageReceiverActiveRecord extends ActiveRecord
{
    /**
     * Statuses.
     */
    const STATUS_NEW = 1;
    const STATUS_READ = 10;
    const STATUS_DELETED = 20;

    /**
     * @var string Sender name
     */
    public $senderName;

    /**
     * @var string Message topic
     */
    public $topic;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%message_receiver}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [TimestampBehavior::class];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return array_merge(
            parent::scenarios(),
            ['remove' => ['receiver_status']]
        );
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['receiver_id', 'message_id'], 'required'],
            [['receiver_id', 'message_id'], 'integer', 'min' => 1],
            ['receiver_status', 'in', 'range' => static::getStatuses()],
            [['senderName', 'topic'], 'string']
        ];
    }

    /**
     * Returns list of statuses.
     * @return string[]
     */
    public static function getStatuses()
    {
        return [self::STATUS_NEW, self::STATUS_READ, self::STATUS_DELETED];
    }

    /**
     * Message relation.
     * @return ActiveQuery
     */
    public function getMessage()
    {
        return $this->hasOne(Message::class, ['id' => 'message_id']);
    }

    /**
     * Receiver relation.
     * @return ActiveQuery
     */
    public function getReceiver()
    {
        return $this->hasOne(User::class, ['id' => 'receiver_id']);
    }
}
