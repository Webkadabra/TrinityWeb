<?php

use yii\db\Migration;

/**
 * Class m180823_070752_settings
 */
class m180823_070752_settings extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%settings}}', [
            'key' => $this->string(128)->notNull(),
            'value' => $this->text()->notNull(),
            'comment' => $this->text(),
            'updated_at' => $this->integer(),
            'created_at' => $this->integer()
        ], $tableOptions);

        $this->addPrimaryKey('pk_key_storage_item_key', '{{%settings}}', 'key');
        $this->createIndex('idx_key_storage_item_key', '{{%settings}}', 'key', true);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%settings}}');
    }
}
