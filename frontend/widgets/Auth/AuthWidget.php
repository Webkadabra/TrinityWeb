<?php

namespace frontend\widgets\Auth;

use frontend\models\forms\LoginForm;
use frontend\models\forms\SignupForm;
use Yii;
use yii\base\Widget;

class AuthWidget extends Widget {
    const AUTH = 'auth';
    const SIGNUP = 'signup';
    
    public $action = null;
    
    /**
     * Executes the widget.
     * @return string the result of widget execution to be outputted.
     */
    public function run() {
        if($this->action) {
            switch ($this->action) {
                case self::AUTH:
                    $model = new LoginForm();
                    $captcha = Yii::$app->settings->get(Yii::$app->settings::APP_CAPTCHA_STATUS) === Yii::$app->settings::ENABLED ? true : false;
                    $model->scenario = $captcha ? LoginForm::CAPTCHA : LoginForm::NON_CAPTCHA;
                    echo $this->render('sign-in', [
                        'model' => $model
                    ]);
                    break;
                case self::SIGNUP:
                    $model = new SignupForm();
                    $captcha = Yii::$app->settings->get(Yii::$app->settings::APP_CAPTCHA_STATUS) === Yii::$app->settings::ENABLED ? true : false;
                    $model->scenario = $captcha ? SignupForm::CAPTCHA : SignupForm::NON_CAPTCHA;
                    echo $this->render('sign-up', [
                        'model' => $model
                    ]);
                    break;
            }
        } else return null;
    }
}