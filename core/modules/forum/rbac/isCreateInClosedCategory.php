<?php

namespace core\modules\forum\rbac;

use yii\rbac\Rule;

class isCreateInClosedCategory extends Rule
{
    public $name = 'isLockedCategory';

    /**
     * @param string|integer $user the user ID.
     * @param \yii\rbac\Item $item the role or permission that this rule is associated with
     * @param array $params parameters passed to ManagerInterface::checkAccess().
     * @return bool a value indicating whether the rule permits the role or permission it is associated with.
     */
    public function execute($user, $item, $params)
    {
        if(isset($params['category'])) {
            return !$params['category']->isLocked() ? true : false;
        }

        return false;
    }
}
