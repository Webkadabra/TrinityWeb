<?php

use core\models\User;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%user_ignore}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $ignored_id
 *
 * @property User $user
 * @property User $ignoredUser
 */
class UserIgnore extends ActiveRecord {
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_ignore}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'ignored_id'], 'required'],
            [['user_id', 'ignored_id'], 'integer'],
            [['user_id'], 'exist', 'targetClass' => User::class, 'targetAttribute' => 'id'],
            [['ignored_id'], 'exist', 'targetClass' => User::class, 'targetAttribute' => 'id'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id'    => Yii::t('common', 'User'),
            'ignored_id' => Yii::t('common', 'Ignored user'),
        ];
    }

    public function getUser() {
        return $this->hasOne(User::class,['id' => 'user_id']);
    }

    public function getIgnoredUser() {
        return $this->hasOne(User::class,['id' => 'ignored_id']);
    }
}