<?php
namespace core\modules\installer\models\setup;

use Yii;
use yii\base\Model;
use yii\base\Exception;

use core\commands\AddToTimelineCommand;

use core\models\UserProfile;
use core\models\User;


/**
 * SignUpForm
 */
class SignUpForm extends Model
{
    /**
     * @var
     */
    public $username;
    /**
     * @var
     */
    public $email;
    /**
     * @var
     */
    public $password;
    public $r_password;

    public function rules()
    {
        $rules = [
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required'],
            ['username', 'unique',
                'targetClass' => '\core\models\User',
                'message' => Yii::t('frontend', 'This username has already been taken.')
            ],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'unique',
                'targetClass' => '\core\models\User',
                'message' => Yii::t('frontend', 'This email address has already been taken.')
            ],

            [['password', 'r_password'], 'required'],
            [['password', 'r_password'], 'string', 'min' => 6],
            ['r_password', 'compare', 'compareAttribute' => 'password', 'message' => Yii::t('frontend', "Passwords don't match") ],
        ];
        return $rules;
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'username' => Yii::t('frontend', 'Username'),
            'email' => Yii::t('frontend', 'E-mail'),
            'password' => Yii::t('frontend', 'Password'),
            'r_password' => Yii::t('frontend', 'Repeat password'),
        ];
    }

    /**
     * Signs user up.
     *
     * @param null $gameAccount_id
     * @return User|null the saved model or null if saving fails
     * @throws Exception
     * @throws \trntv\bus\exceptions\MissingHandlerException
     * @throws \yii\base\ErrorException
     * @throws \yii\base\InvalidConfigException
     */
    public function signup($gameAccount_id = null)
    {
        if ($this->validate()) {
            $user = new User();
            $user->username = $this->username;
            $user->email = $this->email;
            $user->status = User::STATUS_ACTIVE;
            $user->setPassword($this->password);
            if(!$gameAccount_id) {
                $user->createAccount();
            }
            if(!$user->hasErrors()) {
                if (!$user->save()) {
                    throw new Exception("User couldn't be saved");
                };
                Yii::$app->commandBus->handle(new AddToTimelineCommand([
                    'category' => 'user',
                    'event' => 'signup',
                    'data' => [
                        'public_identity' => $user->getPublicIdentity(),
                        'user_id' => $user->getId(),
                        'created_at' => $user->created_at
                    ]
                ]));
                $profile = new UserProfile();
                $profile->locale = Yii::$app->i18nHelper::getDefaultLocale();
                $profile->load([], '');
                $user->link('userProfile', $profile);
                $auth = Yii::$app->authManager;
                $user->save();
                $role = $auth->getRole(User::ROLE_ADMINISTRATOR);
                $auth->assign($role, $user->getId());
            } else {
                $this->addError('username', $user->getErrors('username')[0]);
            }
            return $user;
        }
        return null;
    }

}