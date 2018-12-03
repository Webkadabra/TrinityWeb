<?php

namespace core\modules\forum\filters;

use core\modules\forum\Podium;
use Yii;

/**
 * Installation access rule
 * Redirects user to installation page if Podium is not installed.
 */
class InstallRule extends PodiumRoleRule
{
    /**
     * @var boolean whether this is an 'allow' rule or 'deny' rule.
     */
    public $allow = false;

    /**
     * Sets match and deny callbacks.
     */
    public function init()
    {
        parent::init();
        $this->matchCallback = function () {
            return !Podium::getInstance()->getInstalled();
        };
        $this->denyCallback = function () {
            return Yii::$app->response->redirect([Podium::getInstance()->prepareRoute('install/run')]);
        };
    }
}
