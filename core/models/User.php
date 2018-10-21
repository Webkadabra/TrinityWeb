<?php

namespace core\models;

use Yii;
use yii\behaviors\AttributeBehavior;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Exception;
use yii\db\Transaction;
use yii\helpers\ArrayHelper;
use yii\web\IdentityInterface;

use core\models\auth\Accounts;

use core\models\query\UserQuery;

use core\commands\AddToTimelineCommand;

/**
 * User model
 *
 * @property integer $id
 * @property integer $auth_id
 * @property integer $realm_id
 * @property integer $character_id
 * @property string $username
 * @property string $slug
 * @property string $password_hash
 * @property string $email
 * @property string $auth_key
 * @property string $access_token
 * @property string $oauth_client
 * @property string $oauth_client_user_id
 * @property integer $role
 * @property string $publicIdentity
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $logged_at
 * @property string $password write-only password
 *
 * @property UserActivity[] $userActivity
 * @property UserFriend[] $userFriends
 * @property UserIgnore[] $ignoredUsers
 * @property UserProfile $userProfile
 * @property UserToken[] $userTokens
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_NOT_ACTIVE = 1;
    const STATUS_ACTIVE = 2;
    const STATUS_DELETED = 3;

    const ROLE_USER = 'user';
    const ROLE_MODERATOR = 'moderator';
    const ROLE_ADMINISTRATOR = 'administrator';

    const EVENT_AFTER_SIGNUP = 'afterSignup';
    const EVENT_AFTER_LOGIN = 'afterLogin';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%users}}';
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::find()
            ->active()
            ->andWhere(['id' => $id])
            ->one();
    }

    /**
     * @return UserQuery
     */
    public static function find()
    {
        return new UserQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::find()
            ->active()
            ->andWhere(['access_token' => $token])
            ->one();
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return User|array|null
     */
    public static function findByUsername($username)
    {
        return static::find()
            ->active()
            ->andWhere(['username' => $username])
            ->one();
    }

    /**
     * Finds user by username or email
     *
     * @param string $login
     * @return User|array|null
     */
    public static function findByLogin($login)
    {
        return static::find()
            ->active()
            ->andWhere(['or', ['username' => $login], ['email' => $login]])
            ->one();
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            'auth_key' => [
                'class' => AttributeBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'auth_key'
                ],
                'value' => Yii::$app->getSecurity()->generateRandomString()
            ],
            'access_token' => [
                'class' => AttributeBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'access_token'
                ],
                'value' => function () {
                    return Yii::$app->getSecurity()->generateRandomString(40);
                }
            ],
            [
            'class' => SluggableBehavior::class,
                'attribute' => 'username',
                'immutable' => true,
            ],
        ];
    }

    /**
     * @return array
     */
    public function scenarios()
    {
        return ArrayHelper::merge(
            parent::scenarios(),
            [
                'oauth_create' => [
                    'oauth_client', 'oauth_client_user_id', 'email', 'username', '!status'
                ]
            ]
        );
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'email'], 'unique'],
            ['slug','string'],
            ['status', 'default', 'value' => self::STATUS_NOT_ACTIVE],
            [['realm_id','character_id', 'auth_id'],'integer'],
            ['status', 'in', 'range' => array_keys(self::statuses())],
            [['username'], 'filter', 'filter' => '\yii\helpers\Html::encode']
        ];
    }

    /**
     * Returns user statuses list
     * @return array|mixed
     */
    public static function statuses()
    {
        return [
            self::STATUS_NOT_ACTIVE => Yii::t('common', 'Not Active'),
            self::STATUS_ACTIVE => Yii::t('common', 'Active'),
            self::STATUS_DELETED => Yii::t('common', 'Deleted')
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'username' => Yii::t('common', 'Username'),
            'email' => Yii::t('common', 'E-mail'),
            'status' => Yii::t('common', 'Status'),
            'access_token' => Yii::t('common', 'API access token'),
            'created_at' => Yii::t('common', 'Created at'),
            'updated_at' => Yii::t('common', 'Updated at'),
            'logged_at' => Yii::t('common', 'Last login'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserProfile()
    {
        return $this->hasOne(UserProfile::class, ['user_id' => 'id']);
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        $hash_password = self::generatePassword($this->username,$password);
        return $this->password_hash == $hash_password ? true : false;
    }

    public function generatePassword($username, $password) {
        return strtoupper(sha1(strtoupper($username).strtoupper(':'.$password.'')));
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = self::generatePassword($this->username, $password);
    }

    /**
     * Creates user profile and application event
     * @param array $profileData
     * @throws \trntv\bus\exceptions\MissingHandlerException
     * @throws \yii\base\ErrorException
     * @throws \yii\base\InvalidConfigException
     */
    public function afterSignup(array $profileData = [])
    {
        $this->refresh();
        Yii::$app->commandBus->handle(new AddToTimelineCommand([
            'category' => 'user',
            'event' => 'signup',
            'data' => [
                'public_identity' => $this->getPublicIdentity(),
                'user_id' => $this->getId(),
                'created_at' => $this->created_at
            ]
        ]));
        $profile = new UserProfile();
        $profile->locale = Yii::$app->i18nHelper::getDefaultLocale();
        $profile->load($profileData, '');
        $this->link('userProfile', $profile);
        $this->trigger(self::EVENT_AFTER_SIGNUP);
        $auth = Yii::$app->authManager;
        $this->save();
        $auth->assign($auth->getRole(User::ROLE_USER), $this->getId());
    }

    /**
     * @throws Exception
     * @throws \yii\base\InvalidConfigException
     */
    public function createAccount()
    {
        $servers = Server::find()->all();
        $executed = [];
        $transactions = [];
        $resultSaved = [];
        foreach($servers as $server) {
            if(!in_array($server->auth_id,$executed)) {
                $executed[] = $server->auth_id;
                $dbConnection = Accounts::getDb($server->auth_id);
                $transactions[] = $dbConnection->beginTransaction();
                try {
                    Accounts::setDb($dbConnection);
                    $account = new Accounts([
                        'username' => $this->username,
                        'sha_pass_hash' => $this->password_hash,
                        'email' => $this->email,
                        'expansion' => $server->getExpansion()
                    ]);
                    $saved = $account->save();
                    $resultSaved[$server->auth_id] = $saved;
                } catch (Exception $ex) {
                    $resultSaved[$server->auth_id] = false;
                }
            }
        }

        $is_all_success = true;
        foreach($resultSaved as $result) {
            if(!$result) $is_all_success = false;
        }

        if($is_all_success) {
            foreach($transactions as $transaction) {
                /* @var Transaction $transaction */
                $transaction->commit();
            }
        } else {
            foreach($transactions as $transaction) {
                /* @var Transaction $transaction */
                $transaction->rollBack();
            }
            $this->addError(
                'username',
                Yii::t('frontend','This username or email already used!')
            );
        }
    }

    /**
     * @throws Exception
     * @throws \yii\base\InvalidConfigException
     */
    public function updatePassword()
    {
        $servers = Server::find()->all();
        $executed = [];
        $transactions = [];
        $resultSaved = [];
        foreach($servers as $server) {
            if(!in_array($server->auth_id,$executed)) {
                $executed[] = $server->auth_id;
                $dbConnection = Accounts::getDb($server->auth_id);
                $transactions[] = $dbConnection->beginTransaction();
                try {
                    Accounts::setDb($dbConnection);
                    $account = Accounts::find()->where(['username' => $this->username])->one();
                    if($account) {
                        $account->sha_pass_hash = $this->password_hash;
                        $saved = $account->save();
                        $resultSaved[$server->auth_id] = $saved;
                    }
                } catch (Exception $ex) {
                    $resultSaved[$server->auth_id] = false;
                }
            }
        }

        $is_all_success = true;
        foreach($resultSaved as $result) {
            if(!$result) $is_all_success = false;
        }

        if($is_all_success) {
            foreach($transactions as $transaction) {
                /* @var Transaction $transaction */
                $transaction->commit();
                $this->save();
            }
            return true;
        } else {
            foreach($transactions as $transaction) {
                /* @var Transaction $transaction */
                $transaction->rollBack();
            }
            $this->addError(
                'password',
                Yii::t('frontend','Errors during update password')
            );
            return false;
        }
    }

    /**
     * @return string
     */
    public function getPublicIdentity()
    {
        if ($this->username) {
            return $this->username;
        }
        return $this->email;
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

}
