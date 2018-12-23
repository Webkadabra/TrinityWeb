<?php

namespace core\models;

use core\modules\i18n\models\Language;
use trntv\filekit\behaviors\UploadBehavior;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%user_profile}}".
 *
 * @property integer $user_id
 * @property string $avatar_path
 * @property string $avatar_base_url
 * @property integer $locale
 * @property string $location
 * @property string $timezone
 * @property string $signature
 * @property string $gender
 * @property string $anonymous
 * @property string $created_at
 * @property string $updated_at
 *
 * @property string $picture
 *
 * @property User $user
 * @property Language $language
 */
class UserProfile extends ActiveRecord
{
    const GENDER_MALE = 1;
    const GENDER_FEMALE = 2;

    /**
     * @var
     */
    public $picture;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_profile}}';
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            'picture' => [
                'class'            => UploadBehavior::class,
                'attribute'        => 'picture',
                'pathAttribute'    => 'avatar_path',
                'baseUrlAttribute' => 'avatar_base_url'
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id', 'gender'], 'integer'],
            [['anonymous','created_at','updated_at'], 'integer'],
            [['anonymous'], 'default', 'value' => 0],
            [['location'], 'string','max' => 32],
            [['timezone'], 'string','max' => 45],
            [['signature'], 'string','max' => 512],
            [['gender'], 'in', 'range' => [NULL, self::GENDER_FEMALE, self::GENDER_MALE]],
            [['avatar_path', 'avatar_base_url'], 'string', 'max' => 255],
            ['locale', 'default', 'value' => Yii::$app->i18nHelper::getDefaultLocale()],
            ['locale', 'in', 'range' => array_keys(Yii::$app->i18nHelper::getIdentLocales())],
            ['picture', 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id'   => Yii::t('common', 'User ID'),
            'locale'    => Yii::t('common', 'Locale'),
            'location'  => Yii::t('common', 'Location'),
            'timezone'  => Yii::t('common', 'Timezone'),
            'signature' => Yii::t('common', 'Signature'),
            'picture'   => Yii::t('common', 'Avatar'),
            'gender'    => Yii::t('common', 'Gender'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function getLanguage() {
        return $this->hasOne(Language::class,['ident' => 'locale']);
    }

    /**
     * @param null $default
     * @return bool|null|string
     */
    public function getAvatar($default = null)
    {
        return $this->avatar_path
            ? Yii::getAlias($this->avatar_base_url . '/' . $this->avatar_path)
            : $default;
    }
}