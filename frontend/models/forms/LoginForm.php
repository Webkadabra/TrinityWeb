<?php

namespace frontend\models\forms;

use Yii;
use yii\base\Model;

use cheatsheet\Time;

use core\validators\ReCaptchaValidator;

use core\models\User;

/**
 * Login form
 */
class LoginForm extends Model
{

    const CAPTCHA = 'captcha';
    const NON_CAPTCHA = 'non_captcha';

    public $identity;
    public $password;
    public $rememberMe = false;

    public $reCaptcha;

    private $user = false;

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::CAPTCHA] = [
            'identity',
            'password',
            'reCaptcha',
            'rememberMe',
        ];
        $scenarios[self::NON_CAPTCHA] = [
            'identity',
            'password',
            'rememberMe'
        ];
        return $scenarios;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $rules = [
            [['identity', 'password'], 'required'],
            ['rememberMe', 'boolean'],
            ['password', 'validatePassword'],
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

    public function attributeLabels()
    {
        return [
            'identity' => Yii::t('frontend', 'Username or email'),
            'password' => Yii::t('frontend', 'Password'),
            'rememberMe' => Yii::t('frontend', 'Remember Me')
        ];
    }


    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     */
    public function validatePassword()
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError('password', Yii::t('frontend', 'Incorrect username or password.'));
            }
        }
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->user === false) {
            $this->user = User::find()
                ->active()
                ->andWhere(['or', ['username' => $this->identity], ['email' => $this->identity]])
                ->one();
        }

        return $this->user;
    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return boolean whether the user is logged in successfully
     * @throws \yii\base\Exception
     */
    public function login()
    {
        if ($this->validate()) {
            if (Yii::$app->user->login($this->getUser(), $this->rememberMe ? Time::SECONDS_IN_A_MONTH : 0)) {
                Yii::$app->DBHelper->setDefault();
                return true;
            }
        }
        return false;
    }
}
