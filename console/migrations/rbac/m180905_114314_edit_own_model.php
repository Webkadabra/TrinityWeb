<?php

use core\models\User;
use core\rbac\Migration;
use core\rbac\rule\OwnModelRule;

class m180905_114314_edit_own_model extends Migration
{
    public function up()
    {
        $rule = new OwnModelRule();
        $this->auth->add($rule);

        $role = $this->auth->getRole(User::ROLE_USER);
        $editOwnModelPermission = $this->auth->createPermission(Yii::$app->PermissionHelper::ACCESS_EDIT_OWN_MODEL);
        $editOwnModelPermission->ruleName = $rule->name;

        $this->auth->add($editOwnModelPermission);
        $this->auth->addChild($role, $editOwnModelPermission);
    }

    public function down()
    {
        $permission = $this->auth->getPermission(Yii::$app->PermissionHelper::ACCESS_EDIT_OWN_MODEL);
        $b_rule = new OwnModelRule();
        $rule = $this->auth->getRule($b_rule->name);

        $this->auth->remove($permission);
        $this->auth->remove($rule);
    }
}
