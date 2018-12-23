<?php

use yii\db\Migration;

/**
 * Class m180823_065000_log
 */
class m180823_065000_logs extends Migration {
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%logs}}', [
            'id'       => $this->primaryKey(),
            'level'    => $this->integer(),
            'category' => $this->string(),
            'log_time' => $this->double(),
            'prefix'   => $this->string(),
            'ip'       => $this->string(20),
            'message'  => $this->text(),
            'model'    => $this->integer(),
            'user_id'  => $this->integer(),
        ], $tableOptions);

        $this->createIndex('idx_level','{{%logs}}','level');
        $this->createIndex('idx_category','{{%logs}}','category');
        $this->createIndex('idx_model','{{%logs}}','model');
        $this->createIndex('idx_prefix','{{%logs}}','prefix');
        $this->createIndex('idx_user_id','{{%logs}}','user_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%logs}}');
    }
}
