<?php

namespace core\modules\forum\db;

use core\modules\forum\Podium;
use yii\db\ActiveRecord as YiiActiveRecord;
use yii\db\Connection;

/**
 * ActiveRecord extended to use Podium db component.
 */
class ActiveRecord extends YiiActiveRecord
{
    /**
     * Returns the database connection used by this AR class.
     * By default, the "db" application component is used as the database connection.
     * You may override this method if you want to use a different database connection.
     * @return Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Podium::getInstance()->db;
    }
}