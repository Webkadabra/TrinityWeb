<?php

namespace core\modules\forum\models\db;

use core\modules\forum\log\Log;
use core\modules\forum\models\Activity;
use core\modules\forum\models\Mod;
use core\modules\forum\models\User;
use core\modules\forum\Podium;
use core\modules\forum\slugs\PodiumSluggableBehavior;
use Exception;
use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\web\IdentityInterface;

/**
 * User AR.
 *
 * @property int $id
 * @property string $username
 * @property string $slug
 * @property string $password_hash
 * @property string $email
 * @property string $auth_key
 * @property int $status
 * @property int $role
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Activity $activity
 * @property Mod[] $mods
 * @property User[] $friends
 */
abstract class UserActiveRecord extends \core\models\User
{
    /**
     * Statuses.
     */
    public const STATUS_REGISTERED = 1;
    public const STATUS_BANNED = 9;

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return array_merge(parent::behaviors(),[
            TimestampBehavior::class,
            [
                'class'     => Podium::getInstance()->slugGenerator,
                'attribute' => 'username',
                'type'      => PodiumSluggableBehavior::USER
            ],
        ]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        try {
            return static::find()->where(['id' => $id, 'status' => self::STATUS_ACTIVE])->limit(1)->one();
        } catch (Exception $exc) {
            Log::warning('Podium is not installed correctly!', null, __METHOD__);

            return null;
        }
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * Activity relation.
     * @return ActiveQuery
     */
    public function getActivity()
    {
        return $this->hasOne(Activity::class, ['user_id' => 'id']);
    }

    /**
     * Friends relation.
     * @return ActiveQuery
     * @since 0.2
     */
    public function getFriends()
    {
        return $this->hasMany(static::class, ['id' => 'friend_id'])->viaTable('{{%user_friend}}', ['user_id' => 'id']);
    }

    /**
     * Moderated forum relation.
     * @return ActiveQuery
     * @since 0.5
     */
    public function getMods()
    {
        return $this->hasMany(Mod::class, ['user_id' => 'id']);
    }
}
