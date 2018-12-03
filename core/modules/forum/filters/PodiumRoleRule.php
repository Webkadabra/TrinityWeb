<?php

namespace core\modules\forum\filters;

use core\modules\forum\models\User;
use yii\filters\AccessRule;
use yii\web\User as YiiUser;

/**
 * Podium role check access rule
 * Overrides matchRole method to ensure use of rbacComponent configuration.
 */
class PodiumRoleRule extends AccessRule
{
    /**
     * @param YiiUser $user the user object
     * @return boolean whether the rule applies to the role
     */
    protected function matchRole($user)
    {
        if (empty($this->roles)) {
            return true;
        }
        foreach ($this->roles as $role) {
            if ($role === '?') {
                if ($user->getIsGuest()) {
                    return true;
                }
            } elseif ($role === '@') {
                if (!$user->getIsGuest()) {
                    return true;
                }
            } elseif (User::can($role)) {
                return true;
            }
        }

        return false;
    }
}
