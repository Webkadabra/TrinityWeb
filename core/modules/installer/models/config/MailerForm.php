<?php

namespace core\modules\installer\models\config;

use Yii;
use yii\base\Model;

/**
 * MailerForm holds basic application settings.
 */
class MailerForm extends Model
{
    public $email = 'admin@tw.local';
    public $robot_email = 'noreply@tw.local';
    
    public $smtp_host = 'localhost';
    public $smtp_username = 'noreply@tw.local';
    public $smtp_password;
    public $smtp_port = 587;
    public $smtp_encrypt;

    /**
     * Declares the validation rules.
     */
    public function rules()
    {
        return [
            [['email', 'robot_email', 'smtp_host', 'smtp_username', 'smtp_password', 'smtp_port'], 'required'],
            [['email', 'robot_email'], 'email'],
            [['smtp_host','smtp_username','smtp_password','smtp_encrypt'], 'string'],
            ['smtp_port', 'integer']
        ];
    }

    public function attributeLabels()
    {
        return [
            'email'         => Yii::t('installer','Administrator Email'),
            'robot_email'   => Yii::t('installer','Robot Email'),
            'smtp_host'     => Yii::t('installer','SMTP host'),
            'smtp_port'     => Yii::t('installer','SMTP port'),
            'smtp_username' => Yii::t('installer','SMTP username'),
            'smtp_password' => Yii::t('installer','SMTP password'),
            'smtp_encrypt'  => Yii::t('installer','SMTP encrypt'),
        ];
    }
}