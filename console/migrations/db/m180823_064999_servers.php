<?php

use yii\db\Migration;

/**
 * Class m180823_064999_servers
 */
class m180823_064999_servers extends Migration {
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%servers}}', [
            'id'                 => $this->primaryKey(),
            'auth_id'            => $this->integer(),
            'realm_id'           => $this->integer(),
            'realm_name'         => $this->string(),
            'realm_slug'         => $this->string(),
            'realm_address'      => $this->string(),
            'realm_localAddress' => $this->string(),
            'realm_port'         => $this->string(),
            'realm_build'        => $this->string(),
            'realm_version'      => $this->string(),
            'visible'            => $this->boolean()->defaultValue(true)
        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%servers}}');
    }
}
