<?php

use yii\db\Migration;

/**
 * Class m180823_074945_messages
 */
class m180823_074945_messages extends Migration
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

        $this->createTable('{{%message}}', [
            'id'            => $this->primaryKey(),
            'sender_id'     => $this->integer()->notNull(),
            'topic'         => $this->string()->notNull(),
            'content'       => $this->text()->notNull(),
            'sender_status' => $this->smallInteger()->notNull()->defaultValue(1),
            'replyto'       => $this->integer()->notNull()->defaultValue(0),
            'created_at'    => $this->integer(),
            'updated_at'    => $this->integer()
        ], $tableOptions);

        $this->createIndex('topic','{{%message}}',['topic']);
        $this->createIndex('replyto','{{%message}}',['replyto']);
        $this->createIndex('sent','{{%message}}',['sender_id', 'sender_status']);

        $this->addForeignKey('fk_message_to_user', '{{%message}}', 'sender_id', '{{%users}}', 'id', 'NO ACTION', 'cascade');

        $this->createTable('{{%message_receiver}}', [
            'id'              => $this->primaryKey(),
            'message_id'      => $this->integer()->notNull(),
            'receiver_id'     => $this->integer()->notNull(),
            'receiver_status' => $this->smallInteger()->notNull()->defaultValue(1),
            'created_at'      => $this->integer(),
            'updated_at'      => $this->integer()
        ], $tableOptions);

        $this->createIndex('inbox','{{%message_receiver}}',['receiver_id', 'receiver_status']);

        $this->addForeignKey('fk_message_receiver_to_message', '{{%message_receiver}}', 'message_id', '{{%message}}', 'id', 'NO ACTION', 'cascade');
        $this->addForeignKey('fk_message_receiver_to_user', '{{%message_receiver}}', 'receiver_id', '{{%users}}', 'id', 'NO ACTION', 'cascade');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_message_to_user','{{%message}}');

        $this->dropForeignKey('fk_message_receiver_to_message','{{%message_receiver}}');
        $this->dropForeignKey('fk_message_receiver_to_user','{{%message_receiver}}');

        $this->dropTable('{{%message_receiver}}');
    }
}
