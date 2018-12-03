<?php

namespace core\modules\forum\web;

use core\modules\forum\Podium;
use yii\rbac\CheckAccessInterface;
use yii\web\User as YiiUser;

/**
 * Podium User component.
 */
class User extends YiiUser
{
    /**
     * Returns the access checker used for checking access.
     * @return CheckAccessInterface
     */
    protected function getAccessChecker()
    {
        return Podium::getInstance()->rbac;
    }
}