<?php

namespace core\validators;

use Yii;
use himiklab\yii2\recaptcha\ReCaptchaValidator as BaseReCaptchaValidator;

class ReCaptchaValidator extends BaseReCaptchaValidator {
    public function init()
    {
        $this->attributes = (array) $this->attributes;
        $this->on = (array) $this->on;
        $this->except = (array) $this->except;
        if ($this->message === null) {
            $this->message = Yii::t('yii', 'The verification code is incorrect.');
        }
    }
}