<?php

namespace core\modules\installer\helpers;

use Yii;
use yii\helpers\Url;

use core\components\settings\Settings;

class TourHelper
{

    const SESSION_NAME = 'trinityweb-install';

    const START = 0;
    const FINISHED = 100;

    /**
     * @param $action
     * @return mixed
     */
    public static function getStepByAction($action) {
        return self::$steps[$action];
    }

    protected static $steps = [
        'prerequisites' => 0,
        'web-database' => 1,
        'install-database' => 2,
        'auth-database' => 3,
        'characters-database' => 4,
        'armory-database' => 5,
        'install-armory-database' => 6,
        'recaptcha' => 7,
        'admin-account' => 8,
        'mailer' => 9,
        'app-settings' => 10,
        'finished' => 100
    ];

    /**
     * @param $step
     * @return mixed
     */
    public static function getActionByStep($step) {
        return array_flip(self::$steps)[$step];
    }

    /**
     * @return array
     */
    public static function getItemsTour()
    {
        $tourList = [
            self::buildItem('System Check', 'prerequisites'),
            self::buildItem('Configuration DB', 'web-database'),
            self::buildItem('Install TrinitWeb DB', 'install-database'),
            self::buildItem('Configuration Auth DB', 'auth-database'),
            self::buildItem('Configuration Character DB`s', 'characters-database'),
            self::buildItem('Configuration Armory DB', 'armory-database'),
            self::buildItem('Install TrinityWeb Armory DB', 'install-armory-database'),
            self::buildItem('ReCaptcha', 'recaptcha'),
            self::buildItem('Create administrator account', 'admin-account'),
            self::buildItem('Mailer', 'mailer'),
            self::buildItem('TrinityWeb settings', 'app-settings'),
            self::buildItem('End of installing', 'finished'),
        ];
        return $tourList;
    }

    /**
     * @param $label
     * @param $action
     * @param string $icon
     * @param bool $forceIcon
     * @return array
     */
    protected static function buildItem($label, $action, $icon = 'fas fa-check', $forceIcon = false)
    {

        $tourStep_action = self::getStepByAction($action);
        $current_step = self::getStep();

        $showIcon = false;

        if($tourStep_action < $current_step || $current_step == self::FINISHED) $showIcon = true;
        if($forceIcon === true) $showIcon = $forceIcon;

        if($tourStep_action > $current_step) {
            return [
                'label' => self::buildLabel($label,$icon, $showIcon),
                'encode' => false,
            ];
        } else {
            return [
                'label' => self::buildLabel($label,$icon, $showIcon),
                'url' => [
                    Url::to([$action])
                ],
                'encode' => false
            ];
        }
    }

    /**
     * @param $label
     * @param $icon
     * @param bool $showIcon
     * @return string
     */
    protected static function buildLabel($label, $icon, $showIcon = false) {
        if($showIcon === true) {
            return "<i class='$icon'></i> " . Yii::t('installer',$label);
        } else {
            return Yii::t('installer', $label);
        }
    }

    /**
     * Init tour session
     */
    public static function initTour() {
        $session = Yii::$app->session;
        $session->open();
        if ($session->isActive) {
            if($session->get(self::SESSION_NAME) === null) {
                $session->set(self::SESSION_NAME, self::START);
            }
        }
    }

    /**
     * Set tour step by action
     * @param $action
     */
    public static function setStep($action) {
        $number_step = self::getStepByAction($action);
        if(static::getStep() < $number_step) {
            Yii::$app->session->set(self::SESSION_NAME, $number_step);
        }
    }

    /**
     * Get tour step
     * @return mixed
     */
    public static function getStep() {
        return Yii::$app->session->get(self::SESSION_NAME);
    }

    /**
     * Set application - installed
     */
    public static function setInstalled() {

        Yii::$app->settings->set(Settings::APP_STATUS, Settings::INSTALLED);
        Yii::$app->settings->set(Settings::APP_MAINTENANCE,Settings::DISABLED);

        Yii::$app->settings->set(Settings::APP_THEME,Settings::DEFAULT_THEME);

    }

}