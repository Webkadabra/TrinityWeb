<?php

use yii\db\Migration;

/**
 * Class m180823_070129_pages
 */
class m180823_070129_pages extends Migration
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

        $this->createTable('{{%page}}', [
            'id' => $this->primaryKey(),
            'slug' => $this->string(2048)->notNull(),
            'view' => $this->string(),
            'status' => $this->smallInteger()->notNull(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions);

        $this->createTable('{{%page_i18n}}', [
            'id' => $this->primaryKey(),
            'page_id' => $this->integer()->notNull(),
            'language' => $this->integer()->notNull(),
            'title' => $this->string(512)->notNull(),
            'body' => $this->text()->notNull(),
            'updated_at' => $this->integer(),
            'created_at' => $this->integer()
        ], $tableOptions);

        $this->createIndex('idx_language','{{%page_i18n}}','language');

        $this->addForeignKey('fk_page_i18n_to_page', '{{%page_i18n}}', 'page_id', '{{%page}}', 'id', 'cascade', 'cascade');
        $this->addForeignKey('fk_page_i18n_to_language', '{{%page_i18n}}', 'language', '{{%language}}', 'ident', 'cascade', 'cascade');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {

        $this->dropForeignKey('fk_page_i18n_to_page','{{%page_i18n}}');
        $this->dropForeignKey('fk_page_i18n_to_language','{{%page_i18n}}');

        $this->dropTable('{{%page}}');
        $this->dropTable('{{%page_i18n}}');
    }
}
