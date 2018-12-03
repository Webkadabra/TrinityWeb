<?php

namespace core\modules\forum\filters;

use core\modules\forum\Podium;
use yii\filters\AccessControl as YiiAccessControl;

/**
 * Podium access control filter
 */
class AccessControl extends YiiAccessControl
{
    /**
     * @var array the default configuration of access rules. Individual rule
     * configurations specified via rules will take precedence when the same
     * property of the rule is configured.
     */
    public $ruleConfig = ['class' => 'core\modules\forum\filters\PodiumRoleRule'];

    /**
     * Sets Podium user component.
     */
    public function init()
    {
        $this->user = Podium::getInstance()->user;
        parent::init();
    }
}
