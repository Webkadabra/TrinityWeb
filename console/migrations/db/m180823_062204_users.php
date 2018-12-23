<?php

use core\models\User;
use yii\db\Migration;

/**
 * Class m180823_062204_users
 */
class m180823_062204_users extends Migration
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

        $this->createTable('{{%users}}', [
            'id'                   => $this->primaryKey(),
            'auth_id'              => $this->integer(),
            'realm_id'             => $this->integer(),
            'character_id'         => $this->integer(),
            'username'             => $this->string()->notNull()->unique(),
            'slug'                 => $this->string()->notNull()->unique(),
            'email'                => $this->string()->notNull(),
            'password_hash'        => $this->string()->notNull(),
            'auth_key'             => $this->string(32)->notNull(),
            'access_token'         => $this->string(40)->notNull(),
            'oauth_client'         => $this->string(),
            'oauth_client_user_id' => $this->string(),
            'role'                 => $this->smallInteger()->notNull()->defaultValue(1),
            'status'               => $this->smallInteger()->notNull()->defaultValue(User::STATUS_ACTIVE),
            'created_at'           => $this->integer(),
            'updated_at'           => $this->integer(),
            'logged_at'            => $this->integer(),
        ], $tableOptions);

        $this->createIndex('idx_username','{{%users}}','username');
        $this->createIndex('idx_status','{{%users}}','status');
        $this->createIndex('idx_role','{{%users}}','role');
        $this->createIndex('idx_email','{{%users}}','email');
        $this->createIndex('idx_mod','{{%users}}',['status','role']);
        $this->createIndex('idx_find_email','{{%users}}',['status','email']);
        $this->createIndex('idx_find_username','{{%users}}',['status','username']);
        $this->createIndex('idx_auth_key','{{%users}}',['auth_key']);

        $this->createTable('{{%user_profile}}', [
            'user_id'         => $this->primaryKey(),
            'avatar_path'     => $this->string(),
            'avatar_base_url' => $this->string(),
            'locale'          => $this->integer()->defaultValue(17)->notNull(),
            'location'        => $this->string(32),
            'timezone'        => $this->string(45),
            'signature'       => $this->string(512),
            'gender'          => $this->smallInteger(1),
            'anonymous'       => $this->smallInteger()->defaultValue(0),
            'created_at'      => $this->integer(),
            'updated_at'      => $this->integer(),
        ], $tableOptions);

        $this->addForeignKey('fk_user_profile_to_user', '{{%user_profile}}', 'user_id', '{{%users}}', 'id', 'cascade', 'cascade');
        $this->addForeignKey('fk_user_profile_to_language', '{{%user_profile}}', 'locale', '{{%language}}', 'ident', 'no action', 'cascade');

        $this->createTable('{{%user_token}}', [
            'id'         => $this->primaryKey(),
            'user_id'    => $this->integer()->notNull(),
            'type'       => $this->string()->notNull(),
            'token'      => $this->string(40)->notNull(),
            'expire_at'  => $this->integer(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer()
        ], $tableOptions);

        $this->addForeignKey('fk_user_token_to_user', '{{%user_token}}', 'user_id', '{{%users}}', 'id', 'cascade', 'cascade');

        $this->createTable('{{%user_ignore}}', [
            'id'         => $this->primaryKey(),
            'user_id'    => $this->integer()->notNull(),
            'ignored_id' => $this->integer()->notNull()
        ], $tableOptions);

        $this->addForeignKey('fk1_user_ignore_to_user', '{{%user_ignore}}', 'user_id', '{{%users}}', 'id', 'cascade', 'cascade');
        $this->addForeignKey('fk2_user_ignore_to_user', '{{%user_ignore}}', 'ignored_id', '{{%users}}', 'id', 'cascade', 'cascade');

        $this->createTable('{{%user_friend}}', [
            'id'        => $this->primaryKey(),
            'user_id'   => $this->integer()->notNull(),
            'friend_id' => $this->integer()->notNull()
        ], $tableOptions);

        $this->addForeignKey('fk1_user_friend_to_user', '{{%user_friend}}', 'user_id', '{{%users}}', 'id', 'cascade', 'cascade');
        $this->addForeignKey('fk2_user_friend_to_user', '{{%user_friend}}', 'friend_id', '{{%users}}', 'id', 'cascade', 'cascade');

        $this->createTable('{{%user_activity}}', [
            'id'         => $this->primaryKey(),
            'user_id'    => $this->integer(),
            'username'   => $this->string(),
            'user_slug'  => $this->string(),
            'user_role'  => $this->integer(),
            'url'        => $this->string(1024)->notNull(),
            'ip'         => $this->string(15),
            'anonymous'  => $this->smallInteger()->notNull()->defaultValue(0),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer()
        ], $tableOptions);

        $this->createIndex('idx_updated_at','{{%user_activity}}',['updated_at']);
        $this->createIndex('idx_members','{{%user_activity}}',['updated_at', 'user_id', 'anonymous']);
        $this->createIndex('idx_guests','{{%user_activity}}',['updated_at', 'user_id']);

        $this->addForeignKey('fk_user_activity_to_user','{{%user_activity}}','user_id','{{%users}}','id','cascade','cascade');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_user','{{%user_profile}}');

        $this->dropForeignKey('fk_user_profile_to_language','{{%user_profile}}');
        $this->dropForeignKey('fk_user_profile_to_user','{{%user_profile}}');

        $this->dropForeignKey('fk_user_token_to_user','{{%user_token}}');

        $this->dropForeignKey('fk1_user_ignore_to_user','{{%user_ignore}}');
        $this->dropForeignKey('fk2_user_ignore_to_user','{{%user_ignore}}');

        $this->dropForeignKey('fk1_user_friend_to_user','{{%user_friend}}');
        $this->dropForeignKey('fk2_user_friend_to_user','{{%user_friend}}');

        $this->dropForeignKey('fk_user_activity_to_user','{{%user_activity}}');

        $this->dropTable('{{%users}}');
        $this->dropTable('{{%user_profile}}');

        $this->dropTable('{{%user_token}}');

        $this->dropTable('{{%user_ignore}}');
        $this->dropTable('{{%user_friend}}');

        $this->dropTable('{{%user_activity}}');
    }
}
