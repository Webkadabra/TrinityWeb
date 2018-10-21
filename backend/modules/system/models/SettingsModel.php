<?php

namespace backend\modules\system\models;

use Yii;
use yii\base\Model;

/**
 * Class SettingsModel
 * @package backend\modules\system\models
 */
class SettingsModel extends Model
{

    /**
     * @var
     */
    public $application_name;
    /**
     * @var
     */
    public $application_tags;
    /**
     * @var
     */
    public $application_description;
    public $application_announce;

    /**
     * @var
     */
    public $application_maintenance;

    /**
     * @var
     */
    public $application_theme;

    /**
     * @var
     */
    public $recaptcha_status;
    /**
     * @var
     */
    public $recaptcha_key;
    /**
     * @var
     */
    public $recaptcha_secret;

    /**
     * @var
     */
    public $mailer_admin;
    /**
     * @var
     */
    public $mailer_robot;

    /**
     * @var
     */
    public $modules;

    /**
     * SettingsModel constructor.
     * @param array $config
     */
    public function __construct(array $config = [])
    {

        $this->application_name = Yii::$app->settings->get(Yii::$app->settings::APP_NAME);
        $this->application_announce = Yii::$app->settings->get(Yii::$app->settings::APP_ANNOUNCE);

        $this->application_maintenance = Yii::$app->settings->get(Yii::$app->settings::APP_MAINTENANCE) == Yii::$app->settings::ENABLED ? 1 : 0;
        $this->application_theme = Yii::$app->settings->get(Yii::$app->settings::APP_THEME);

        $this->recaptcha_status = Yii::$app->settings->get(Yii::$app->settings::APP_CAPTCHA_STATUS) == Yii::$app->settings::ENABLED ? 1 : 0;
        $this->recaptcha_key = Yii::$app->settings->get(Yii::$app->settings::APP_CAPTCHA_KEY);
        $this->recaptcha_secret = Yii::$app->settings->get(Yii::$app->settings::APP_CAPTCHA_SECRET);

        $this->mailer_admin = Yii::$app->settings->get(Yii::$app->settings::APP_MAILER_ADMIN);
        $this->mailer_robot = Yii::$app->settings->get(Yii::$app->settings::APP_MAILER_ROBOT);

        $this->modules = [];
        $this->modules = [
            'ladder' => [
                'label' => Yii::t('backend','Ladder'),
                'field_keys' => [
                    'status' => Yii::$app->settings::APP_MODULE_LADDER_STATUS,
                    'per-page' => Yii::$app->settings::APP_MODULE_LADDER_PER_PAGE,
                    'cache_duration' => Yii::$app->settings::APP_MODULE_LADDER_CACHE_DURATION,
                ],
                'fields' => [
                    'status' => Yii::$app->settings->get(Yii::$app->settings::APP_MODULE_LADDER_STATUS) == Yii::$app->settings::ENABLED ? 1 : 0,
                    'per-page' => Yii::$app->settings->get(Yii::$app->settings::APP_MODULE_LADDER_PER_PAGE),
                    'cache_duration' => Yii::$app->settings->get(Yii::$app->settings::APP_MODULE_LADDER_CACHE_DURATION)
                ],
                'description' => 'Module "Ladder" will show arena team statistics per realm'
            ],
            /*'armory' => [
                'label' => Yii::t('backend','Armory'),
                'field_keys' => [
                    'status' => Yii::$app->TW::MODULE_ARMORY_STATUS,
                    'per-page' => Yii::$app->TW::MODULE_ARMORY_PER_PAGE,
                    'cache_duration' => Yii::$app->TW::MODULE_ARMORY_CACHE_DURATION,
                ],
                'fields' => [
                    'status' => Yii::$app->settings->get(Yii::$app->TW::MODULE_ARMORY_STATUS) == Yii::$app->TW::ENABLED ? 1 : 0,
                    'per-page' => Yii::$app->settings->get(Yii::$app->TW::MODULE_ARMORY_PER_PAGE),
                    'cache_duration' => Yii::$app->settings->get(Yii::$app->TW::MODULE_ARMORY_CACHE_DURATION)
                ],
                'description' => 'Модуль "Армори", который позволяет просматривать персонажа (хар-ки,вещи, последние достижения, таланты, команды арен)'
            ],
            'forum' => [
                'label' => Yii::t('backend','Forum'),
                'field_keys' => [
                    'status' => Yii::$app->TW::MODULE_FORUM_STATUS
                ],
                'fields' => [
                    'status' => Yii::$app->settings->get(Yii::$app->TW::MODULE_FORUM_STATUS) == Yii::$app->TW::ENABLED ? 1 : 0
                ],
                'description' => 'Модуль "Форум"'
            ],
            'bugtracker' => [
                'label' => Yii::t('backend','BugTracker'),
                'field_keys' => [
                    'status' => Yii::$app->TW::MODULE_BUGTRACKER_STATUS
                ],
                'fields' => [
                    'status' => Yii::$app->settings->get(Yii::$app->TW::MODULE_BUGTRACKER_STATUS) == Yii::$app->TW::ENABLED ? 1 : 0
                ],
                'description' => 'Модуль "БагТрекер" - позволяет пользователям оставлять ошибки'
            ]*/
        ];

        parent::__construct($config);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['application_name','application_description', 'application_announce'],'string'],
            [['application_name'],'string', 'max' => 32],
            [['recaptcha_status', 'application_maintenance'],'boolean'],
            [['mailer_robot','mailer_admin'],'string', 'max' => 32],
            [['application_description', 'application_theme'],'string', 'max' => 255],
            [['recaptcha_secret','recaptcha_key'],'string', 'max' => 64],
            [['modules','application_tags'],'safe']
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'application_name' => Yii::t('backend','Application name'),
            'application_tags' => Yii::t('backend','Application tags'),
            'application_description' => Yii::t('backend','Application description'),
            'application_maintenance' => Yii::t('backend','Application Maintenance'),
            'application_announce' => Yii::t('backend','Application Announce')
        ];
    }

    /**
     * @param $postData
     * @return bool
     */
    public function save($postData) {
        if($this->load($postData) && $this->validate()) {

            Yii::$app->settings->set(Yii::$app->settings::APP_NAME, $this->application_name);
            Yii::$app->settings->set(Yii::$app->settings::APP_ANNOUNCE, $this->application_announce);

            Yii::$app->settings->set(Yii::$app->settings::APP_MAILER_ROBOT, $this->mailer_robot);
            Yii::$app->settings->set(Yii::$app->settings::APP_MAILER_ADMIN, $this->mailer_admin);
            Yii::$app->settings->set(Yii::$app->settings::APP_THEME, $this->application_theme);

            if($this->recaptcha_status && $this->recaptcha_key && $this->recaptcha_secret) {
                Yii::$app->settings->set(Yii::$app->settings::APP_CAPTCHA_STATUS,Yii::$app->settings::ENABLED);
                Yii::$app->settings->set(Yii::$app->settings::APP_CAPTCHA_KEY,$this->recaptcha_key);
                Yii::$app->settings->set(Yii::$app->settings::APP_CAPTCHA_SECRET,$this->recaptcha_secret);
            } else {
                Yii::$app->settings->set(Yii::$app->settings::APP_CAPTCHA_STATUS,Yii::$app->settings::DISABLED);
                if((!$this->recaptcha_key || !$this->recaptcha_secret) && $this->recaptcha_status) {
                    Yii::$app->session->setFlash('warning', Yii::t('backend', 'конфигурация для reCaptcha неправильная. Установлен статус - выключена'));
                }
            }

            Yii::$app->settings->set(
                Yii::$app->settings::APP_MAINTENANCE,
                $this->application_maintenance ?
                    Yii::$app->settings::ENABLED : Yii::$app->settings::DISABLED
            );

            if($modulesData = $postData['Module']) {
                foreach ($this->modules as $key => $module) {
                    if(isset($modulesData[$key])) {
                        if(isset($modulesData[$key]['status'])) {
                            Yii::$app->settings->set($module['field_keys']['status'],Yii::$app->settings::ENABLED);
                        } else {
                            Yii::$app->settings->set($module['field_keys']['status'],Yii::$app->settings::DISABLED);
                        }
                        if(isset($modulesData[$key]['per-page'])) {
                            if($modulesData[$key]['per-page']) Yii::$app->settings->set($module['field_keys']['per-page'],$modulesData[$key]['per-page']);
                        }
                        if(isset($modulesData[$key]['cache_duration'])) {
                            if($modulesData[$key]['cache_duration']) Yii::$app->settings->set($module['field_keys']['cache_duration'],$modulesData[$key]['cache_duration']);
                        }
                    }
                }
            }
            return true;
        }
        return false;
    }

}
