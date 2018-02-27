<?php

use common\models\User;
use yii\db\Schema;
use yii\db\Migration;

class m160203_096238_user_points extends Migration
{
    public function up()
    {
        $this->addColumn('{{%user}}','vCoin', $this->integer());
        $this->addColumn('{{%user}}','dCoin', $this->integer());
        
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        
        $this->createTable('{{%user_payment_history}}', [
            'id' => $this->primaryKey(),
            'merchant_id' => $this->integer(),
            'user_id' => $this->integer(),
            'amount' => $this->integer(),
            'currency_id' => $this->integer(),
            'sign' => $this->string(),
            'operation_data' => $this->string(),
            'operation_time_success' => $this->integer(),
            'operation_time_complete' => $this->integer(),
            'status' => $this->integer(),
        ]);
        
    }
}
