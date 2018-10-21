<?php

use core\models\User;
use core\rbac\Migration;

/**
 * Class m180905_112924_rbac_roles
 */
class m180905_112924_rbac_roles extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->auth->removeAll();

        $user = $this->auth->createRole(User::ROLE_USER);
        $this->auth->add($user);

        $moderator = $this->auth->createRole(User::ROLE_MODERATOR);
        $this->auth->add($moderator);
        $this->auth->addChild($moderator, $user);

        $admin = $this->auth->createRole(User::ROLE_ADMINISTRATOR);
        $this->auth->add($admin);
        $this->auth->addChild($admin, $moderator);
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->auth->remove($this->auth->getRole(User::ROLE_ADMINISTRATOR));
        $this->auth->remove($this->auth->getRole(User::ROLE_MODERATOR));
        $this->auth->remove($this->auth->getRole(User::ROLE_USER));
    }
}
