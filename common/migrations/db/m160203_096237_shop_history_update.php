<?php

use common\models\User;
use yii\db\Schema;
use yii\db\Migration;

class m160203_096237_shop_history_update extends Migration
{
    public function up()
    {
        $this->addColumn('{{%shop_history}}','operation_cur', $this->integer());
    }
}
