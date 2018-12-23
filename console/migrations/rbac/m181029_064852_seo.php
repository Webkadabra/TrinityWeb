<?php

use core\models\User;
use core\rbac\Migration;

class m181029_064852_seo extends Migration
{
    public function up()
    {
        $access_to_seo = $this->auth->createPermission(Yii::$app->PermissionHelper::ACCESS_BACKEND_TO_SEO);
        $this->auth->add($access_to_seo);

        $role_administrator = $this->auth->getRole(User::ROLE_ADMINISTRATOR);
        $this->auth->addChild($role_administrator, $access_to_seo);
    }

    public function down()
    {
        $this->auth->remove($this->auth->getPermission(Yii::$app->PermissionHelper::ACCESS_BACKEND_TO_SEO));
    }
}
