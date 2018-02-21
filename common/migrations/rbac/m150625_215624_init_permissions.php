<?php

use common\rbac\Migration;

class m150625_215624_init_permissions extends Migration
{
    public function up()
    {
        $managerRole = $this->auth->getRole(\common\models\User::ROLE_MODERATOR);
        $intepreterRole = $this->auth->getRole(\common\models\User::ROLE_INTERPRETER);
        $loginToBackend = $this->auth->createPermission('loginToBackend');
        $this->auth->add($loginToBackend);
        $this->auth->addChild($managerRole, $loginToBackend);
        $this->auth->addChild($intepreterRole, $loginToBackend);
    }

    public function down()
    {
        $this->auth->remove($this->auth->getPermission('loginToBackend'));
    }
}
