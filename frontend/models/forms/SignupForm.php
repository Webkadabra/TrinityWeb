<?php

namespace frontend\models\forms;

use Yii;
use yii\base\Exception;
use yii\base\Model;

use core\validators\ReCaptchaValidator;

use core\models\User;

/**
 * Signup form
 */
class SignupForm extends Model
{

    const CAPTCHA = 'CAPTCHA';
    const NON_CAPTCHA = 'NON_CAPTCHA';

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

    public $reCaptcha;

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::CAPTCHA] = [
            'username',
            'password',
            'reCaptcha',
            'email',
            'r_password'
        ];
        $scenarios[self::NON_CAPTCHA] = [
            'username',
            'password',
            'r_password',
            'email'
        ];
        return $scenarios;
    }

    /**
     * @inheritdoc
     */
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

        if(Yii::$app->settings->get(Yii::$app->settings::APP_CAPTCHA_STATUS) == Yii::$app->settings::ENABLED) {
            $rules[] = [
                ['reCaptcha'],
                ReCaptchaValidator::class,
                'on' => self::CAPTCHA,
                'except' => self::NON_CAPTCHA,
                'skipOnEmpty' => false,
                'secret' => Yii::$app->settings->get(Yii::$app->settings::APP_CAPTCHA_SECRET),
                'uncheckedMessage' => Yii::t('frontend','Please confirm that you are not a bot.')
            ];
        }

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
     * @param null $role
     * @param bool $no_check_forum
     * @param null $game_account
     * @return User|null the saved model or null if saving fails
     * @throws Exception
     * @throws \Exception
     * @throws \trntv\bus\exceptions\MissingHandlerException
     * @throws \yii\base\InvalidConfigException
     */
    public function signup()
    {
        if ($this->validate()) {
            $user = new User();
            $user->username = $this->username;
            $user->email = $this->email;
            $user->status = User::STATUS_ACTIVE;
            $user->setPassword($this->password);
            $user->createAccount();
            if(!$user->hasErrors()) {
                if (!$user->save()) {
                    throw new Exception("User couldn't be saved");
                };
                $user->afterSignup([]);
            } else {
                $this->addError('username', $user->getErrors('username')[0]);
            }
            return $user;
        }
        return null;
    }
}
