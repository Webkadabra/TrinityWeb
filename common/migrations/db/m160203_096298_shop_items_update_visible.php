<?php

use common\models\User;
use yii\db\Schema;
use yii\db\Migration;

class m160203_096298_shop_items_update_visible extends Migration
{
    public function up()
    {
        $this->addColumn('{{%shop_items}}','visible', $this->boolean()->defaultValue(true));
    }
}
