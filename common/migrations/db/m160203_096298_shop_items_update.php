<?php

use common\models\User;
use yii\db\Schema;
use yii\db\Migration;

class m160203_096298_shop_items_update extends Migration
{
    public function up()
    {
        $this->dropColumn('{{%shop_items}}', 'cost');
        $this->addColumn('{{%shop_items}}','vCoins', $this->integer());
        $this->addColumn('{{%shop_items}}','dCoins', $this->integer());
    }
}
