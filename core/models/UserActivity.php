<?php

namespace core\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%user_activity}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $username
 * @property string $user_slug
 * @property integer $user_role
 * @property string $url
 * @property string $ip
 * @property integer $anonymous
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property User $user
 */
class UserActivity extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_activity}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [TimestampBehavior::class];
    }

    /**
     * User relation.
     * @return ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}