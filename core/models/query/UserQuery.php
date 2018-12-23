<?php

namespace core\models\query;

use core\models\User;
use yii\db\ActiveQuery;

/**
 * Class UserQuery
 * @package core\models\query
 */
class UserQuery extends ActiveQuery
{
    /**
     * @return $this
     */
    public function notDeleted()
    {
        $this->andWhere(['!=', 'status', User::STATUS_DELETED]);

        return $this;
    }

    /**
     * @return $this
     */
    public function active()
    {
        $this->andWhere(['status' => User::STATUS_ACTIVE]);

        return $this;
    }

    public function getAdministrators()
    {
        return $this->andWhere(['role' => User::ROLE_INT_ADMINISTRATOR]);
    }
}