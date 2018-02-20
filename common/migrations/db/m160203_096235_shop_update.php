<?php

use common\models\User;
use yii\db\Schema;
use yii\db\Migration;

class m160203_096235_shop_update extends Migration
{
    public function up()
    {
        $this->addColumn('{{%shop_category}}','discount_end', $this->string());
    }
}
