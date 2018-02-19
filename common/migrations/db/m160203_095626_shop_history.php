<?php

use yii\db\Migration;

class m160203_095626_shop_history extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        
        $this->createTable('{{%shop_history}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'realm_id' => $this->integer()->notNull(),
            'character_id' => $this->integer()->notNull(),
            'is_gift' => $this->boolean(),
            'operation_data' => $this->text()->notNull(),
            'operation_time' => $this->integer()->notNull(),
            'operation_cost' => $this->integer(),
        ]);
        
    }

    public function down()
    {
        $this->dropTable('{{%shop_history}}');
    }
}