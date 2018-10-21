<?php

namespace core\models;

use Exception;
use Yii;
use yii\db\ActiveRecord;
use yii\db\ActiveQuery;
use yii\helpers\HtmlPurifier;

use core\components\logs\Log;


/**
 * Message model
 *
 * @property integer $id
 * @property integer $sender_id
 * @property string $topic
 * @property string $content
 * @property integer $replyto
 * @property integer $sender_status
 * @property integer $updated_at
 * @property integer $created_at
 * @property string $parsedContent
 *
 * @property MessageReceiver[] $messageReceivers
 *
 */
class Message extends ActiveRecord
{

    /**
     * Statuses.
     */
    const STATUS_NEW     = 1;
    const STATUS_READ    = 10;
    const STATUS_DELETED = 20;

    /**
     * Limits.
     */
    const MAX_RECEIVERS = 10;
    const SPAM_MESSAGES = 10;
    const SPAM_WAIT     = 1;

    /**
     * @var int[] Receivers' IDs.
     */
    public $receiversId;

    /**
     * @var int[] Friends' IDs.
     */
    public $friendsId;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%message}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [TimestampBehavior::className()];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return array_merge(
            parent::scenarios(),
            [
                'report' => ['content'],
                'remove' => ['sender_status'],
            ]
        );
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['topic', 'content'], 'required'],
            [['receiversId', 'friendsId'], 'each', 'rule' => ['integer', 'min' => 1]],
            ['sender_status', 'in', 'range' => self::getStatuses()],
            ['topic', 'string', 'max' => 255],
            ['topic', 'filter', 'filter' => function($value) {
                return HtmlPurifier::process(trim($value));
            }],
            ['content', 'filter', 'filter' => function($value) {
                return HtmlPurifier::process(trim($value), Yii::$app->TW::purifierConfig());
            }],
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
     * Returns list of inbox statuses.
     * @return string[]
     */
    public static function getInboxStatuses()
    {
        return [self::STATUS_NEW, self::STATUS_READ];
    }

    /**
     * Returns list of sent statuses.
     * @return string[]
     */
    public static function getSentStatuses()
    {
        return [self::STATUS_READ];
    }

    /**
     * Returns list of deleted statuses.
     * @return string[]
     */
    public static function getDeletedStatuses()
    {
        return [self::STATUS_DELETED];
    }

    /**
     * Sender relation.
     * @return ActiveQuery
     */
    public function getSender()
    {
        return $this->hasOne(User::className(), ['id' => 'sender_id']);
    }

    /**
     * Receivers relation.
     * @return ActiveQuery
     */
    public function getMessageReceivers()
    {
        return $this->hasMany(MessageReceiver::className(), ['message_id' => 'id']);
    }

    /**
     * Returns reply Message.
     * @return ActiveQuery
     */
    public function getReply()
    {
        return $this->hasOne(static::className(), ['id' => 'replyto']);
    }

    /**
     * Returns Re: prefix for subject.
     * @return string
     */
    public static function re()
    {
        return Yii::t('common', 'Re:');
    }

    /**
     * Checks if user is a message receiver.
     * @param int $userId
     * @return bool
     */
    public function isMessageReceiver($userId)
    {
        if ($this->messageReceivers) {
            foreach ($this->messageReceivers as $receiver) {
                if ($receiver->receiver_id == $userId) {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * Sends message.
     * @return bool
     * @throws \yii\db\Exception
     */
    public function send()
    {
        $transaction = static::getDb()->beginTransaction();
        try {
            $this->sender_id = Yii::$app->user->getId();
            $this->sender_status = self::STATUS_READ;

            if (!$this->save()) {
                throw new Exception('Message saving error!');
            }

            $count = count($this->receiversId);
            foreach ($this->receiversId as $receiver) {
                if (!(new ActiveQuery())->select('id')->from(User::tableName())->where(['id' => $receiver, 'status' => User::STATUS_ACTIVE])->exists()) {
                    if ($count == 1) {
                        throw new Exception('No active receivers to send message to!');
                    }
                    continue;
                }
                $message = new MessageReceiver();
                $message->message_id = $this->id;
                $message->receiver_id = $receiver;
                $message->receiver_status = self::STATUS_NEW;
                if (!$message->save()) {
                    throw new Exception('MessageReceiver saving error!');
                }
                Yii::$app->TW::deleteCacheElement('user.newmessages', $receiver);
            }
            $transaction->commit();
            $sessionKey = 'messages.' . $this->sender_id;
            if (Yii::$app->session->has($sessionKey)) {
                $sentAlready = explode('|', Yii::$app->session->get($sessionKey));
                $sentAlready[] = time();
                Yii::$app->session->set($sessionKey, implode('|', $sentAlready));
            } else {
                Yii::$app->session->set($sessionKey, time());
            }
            return true;
        } catch (Exception $e) {
            $transaction->rollBack();
            Log::error($e->getMessage(), $this->id, __METHOD__);
        }
        return false;
    }

    /**
     * Checks if user sent already more than SPAM_MESSAGES in last SPAM_WAIT
     * minutes.
     * @param int $userId
     * @return bool
     */
    public static function tooMany($userId)
    {
        $sessionKey = 'messages.' . $userId;
        if (Yii::$app->session->has($sessionKey)) {
            $sentAlready = explode('|', Yii::$app->session->get($sessionKey));
            $validated = [];
            foreach ($sentAlready as $t) {
                if (preg_match('/^[0-9]+$/', $t)) {
                    if ($t > time() - self::SPAM_WAIT * 60) {
                        $validated[] = $t;
                    }
                }
            }
            Yii::$app->session->set($sessionKey, implode('|', $validated));
            if (count($validated) >= self::SPAM_MESSAGES) {
                return true;
            }
        }
        return false;
    }

    /**
     * Removes message.
     * @return bool
     * @throws \Throwable
     * @throws \yii\db\Exception
     */
    public function remove()
    {
        $transaction = static::getDb()->beginTransaction();
        try {
            $clearCache = false;
            if ($this->sender_status == self::STATUS_NEW) {
                $clearCache = true;
            }
            $this->scenario = 'remove';
            if (empty($this->messageReceivers)) {
                if (!$this->delete()) {
                    throw new Exception('Message removing error!');
                }
                if ($clearCache) {
                    Yii::$app->TW::deleteCacheElement('user.newmessages', $this->sender_id);
                }
                $transaction->commit();
                return true;
            }
            $allDeleted = true;
            foreach ($this->messageReceivers as $mr) {
                if ($mr->receiver_status != MessageReceiver::STATUS_DELETED) {
                    $allDeleted = false;
                    break;
                }
            }
            if ($allDeleted) {
                foreach ($this->messageReceivers as $mr) {
                    if (!$mr->delete()) {
                        throw new Exception('Received message removing error!');
                    }
                }
                if (!$this->delete()) {
                    throw new Exception('Message removing error!');
                }
                if ($clearCache) {
                    Yii::$app->TW::deleteCacheElement('user.newmessages', $this->sender_id);
                }
                $transaction->commit();
                return true;
            }
            $this->sender_status = self::STATUS_DELETED;
            if (!$this->save()) {
                throw new Exception('Message status changing error!');
            }
            if ($clearCache) {
                Yii::$app->TW::deleteCacheElement('user.newmessages', $this->sender_id);
            }
            $transaction->commit();
            return true;
        } catch (Exception $e) {
            $transaction->rollBack();
            Log::error($e->getMessage(), $this->id, __METHOD__);
        }
        return false;
    }

    /**
     * Marks message read.
     */
    public function markRead()
    {
        if ($this->sender_status == self::STATUS_NEW) {
            $this->sender_status = self::STATUS_READ;
            if ($this->save()) {
                Yii::$app->TW::deleteCacheElement('user.newmessages', $this->sender_id);
            }
        }
    }
}