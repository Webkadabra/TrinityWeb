<?php

namespace core\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%user_friend}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $friend_id
 *
 * @property User $user
 * @property User $friendUser
 */
class UserFriend extends ActiveRecord {
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_friend}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'friend_id'], 'required'],
            [['user_id', 'friend_id'], 'integer'],
            [['user_id'], 'exist', 'targetClass' => User::class, 'targetAttribute' => 'id'],
            [['friend_id'], 'exist', 'targetClass' => User::class, 'targetAttribute' => 'id'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id'   => Yii::t('common', 'User'),
            'friend_id' => Yii::t('common', 'Friend user'),
        ];
    }

    public function getUser() {
        return $this->hasOne(User::class,['id' => 'user_id']);
    }

    public function getFriendUser() {
        return $this->hasOne(User::class,['id' => 'friend_id']);
    }
}