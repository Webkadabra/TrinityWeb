<?php

use yii\db\Migration;

/**
 * Class m180823_092006_meta
 */
class m180823_092006_meta extends Migration
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

        $this->createTable('{{%meta}}', [
            'id' => $this->primaryKey(),
            'route' => $this->string()->notNull(),
            'robots_index' => 'ENUM(\'INDEX\',\'NOINDEX\') NULL',
            'robots_follow' => 'ENUM(\'FOLLOW\',\'NOFOLLOW\') NULL',
            'updated_at' => $this->integer(),
            'created_at' => $this->integer()
        ], $tableOptions);

        $this->createIndex('idx_route','{{%meta}}', 'route');

        $this->createTable('{{%meta_i18n}}', [
            'id' => $this->primaryKey(),
            'meta_id' => $this->integer()->notNull(),
            'language' => $this->integer()->notNull(),
            'title' => $this->string(255),
            'keywords' => $this->text(),
            'description' => $this->text(),
            'updated_at' => $this->integer(),
            'created_at' => $this->integer()
        ], $tableOptions);

        $this->createIndex('idx_language','{{%meta_i18n}}','language');

        $this->addForeignKey('fk_meta_i18n_to_meta', '{{%meta_i18n}}', 'meta_id', '{{%meta}}', 'id', 'cascade', 'cascade');
        $this->addForeignKey('fk_meta_i18n_to_language', '{{%meta_i18n}}', 'language', '{{%language}}', 'ident', 'cascade', 'cascade');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_meta_i18n_to_meta','{{%meta_i18n}}');
        $this->dropForeignKey('fk_meta_i18n_to_language','{{%meta_i18n}}');

        $this->dropTable('{{%meta}}');
        $this->dropTable('{{%meta_i18n}}');
    }
}
