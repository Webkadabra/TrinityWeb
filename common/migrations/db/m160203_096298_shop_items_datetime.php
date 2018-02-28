<?php

use common\models\User;
use yii\db\Schema;
use yii\db\Migration;

class m160203_096298_shop_items_datetime extends Migration
{
    public function up()
    {
        $this->alterColumn('{{%shop_items}}','discount_end', $this->string());
    }
}
