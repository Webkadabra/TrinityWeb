<?php

use common\models\User;
use yii\db\Migration;

class m160203_096299_key_add extends Migration
{
    public function safeUp()
    {
        $this->insert('{{%key_storage_item}}', [
            'key' => 'frontend.cache_store_search',
            'value' => '120',
            'comment' => 'Cache time in seconds - store search'
        ]);
        
    }

    public function safeDown()
    {
        $this->delete('{{%key_storage_item}}', [
            'key' => 'frontend.cache_store_search'
        ]);
    }
}
