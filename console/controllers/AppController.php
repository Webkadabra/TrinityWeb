<?php

namespace console\controllers;

use Yii;
use yii\base\Module;
use yii\console\Controller;
use yii\helpers\Console;
use common\models\auth\Accounts;
use common\models\User;

/**
 * @author Eugene Terentev <eugene@terentev.net>
 */
class AppController extends Controller
{
    public $writablePaths = [
        '@common/runtime',
        '@frontend/runtime',
        '@frontend/web/assets',
        '@backend/runtime',
        '@backend/web/assets',
        '@storage/cache',
        '@storage/web/source'
    ];
    public $executablePaths = [
        '@backend/yii',
        '@frontend/yii',
        '@console/yii',
    ];
    public $generateKeysPaths = [
        '@base/.env'
    ];

    /**
     * Sets given keys to .env file
     */
    public function actionSetKeys()
    {
        $this->setKeys($this->generateKeysPaths);
    }

    /**
     * @throws \yii\base\InvalidRouteException
     * @throws \yii\console\Exception
     */
    public function actionSetup()
    {   
        $this->runAction('drop', ['interactive' => $this->interactive]);
        $this->runAction('set-writable', ['interactive' => $this->interactive]);
        $this->runAction('set-executable', ['interactive' => $this->interactive]);
        $this->runAction('set-keys', ['interactive' => $this->interactive]);
        $this->setGenerateCharactersConfig(Yii::getAlias('@common') . '/config/');
        \Yii::$app->runAction('migrate/up', ['interactive' => $this->interactive]);
        \Yii::$app->runAction('rbac-migrate/up', ['interactive' => $this->interactive]);
        \Yii::$app->runAction('forum/install/init', ['interactive' => $this->interactive]);
        \Yii::$app->runAction('translate/base', ['interactive' => $this->interactive]);
    }

    public function actionSyncAccounts() {
        $limit = 1000;
        $page = 0;
        $models = Accounts::find()->offset($page * $limit)->limit($limit)->all();
        while($models) {
            foreach ($models as $model) {
                $user = User::findOne(['external_id' => $model->id]);
                if(!$user) {
                    $user = new User();
                    $user->password_hash = $model->sha_pass_hash;
                    $user->username = $model->username;
                    $user->email = $model->email;
                    $user->external_id = $model->id;
                    $user->save();
                    $user->afterSignup();
                }
            }
            $page++;
            $models = Accounts::find()->offset($page * $limit)->limit($limit)->all();
        }
    }
    
    /**
     * Truncates all tables in the database.
     * @throws \yii\db\Exception
     */
    public function actionTruncate()
    {
        $dbName = Yii::$app->db->createCommand('SELECT DATABASE()')->queryScalar();
        if ($this->confirm('This will truncate all tables of current database [' . $dbName . '].')) {
            Yii::$app->db->createCommand('SET FOREIGN_KEY_CHECKS=0')->execute();
            $command = Yii::$app->db->createCommand("SHOW FULL TABLES WHERE TABLE_TYPE LIKE '%TABLE'");
            $res = $command->queryAll();
            foreach ($res as $row) {
                $rowName = sprintf('Tables_in_%s', $dbName);
                $this->stdout('Truncating table ' . $row[$rowName] . PHP_EOL, Console::FG_RED);
                Yii::$app->db->createCommand()->truncateTable($row[$rowName])->execute();
            }
            Yii::$app->db->createCommand('SET FOREIGN_KEY_CHECKS=1')->execute();
        }
    }
    
    /**
     * Drops all tables in the database.
     * @throws \yii\db\Exception
     */
    public function actionDrop()
    {
        $dbName = Yii::$app->db->createCommand('SELECT DATABASE()')->queryScalar();
        if ($this->confirm('This will drop all tables of current database [' . $dbName . '].')) {
            Yii::$app->db->createCommand("SET foreign_key_checks = 0")->execute();
            $tables = Yii::$app->db->schema->getTableNames();
            foreach ($tables as $table) {
                $this->stdout('Dropping table ' . $table . PHP_EOL, Console::FG_RED);
                Yii::$app->db->createCommand()->dropTable($table)->execute();
            }
            Yii::$app->db->createCommand("SET foreign_key_checks = 1")->execute();
        }
    }

    /**
     * Drops all tables in the armory database.
     * @throws \yii\db\Exception
     */
    public function actionArmoryDrop()
    {
        $dbName = Yii::$app->armory_db->createCommand('SELECT DATABASE()')->queryScalar();
        if ($this->confirm('This will install clear armory dump of current database and drop existing tables in database [' . $dbName . '].')) {
            Yii::$app->armory_db->createCommand("SET foreign_key_checks = 0")->execute();
            $tables = Yii::$app->armory_db->schema->getTableNames();
            foreach ($tables as $table) {
                $this->stdout('Dropping table ' . $table . PHP_EOL, Console::FG_RED);
                Yii::$app->armory_db->createCommand()->dropTable($table)->execute();
            }
            Yii::$app->armory_db->createCommand("SET foreign_key_checks = 1");
            
        }
    }

    /**
     * Adds write permissions
     */
    public function actionSetWritable()
    {
        $this->setWritable($this->writablePaths);
    }

    /**
     * Adds execute permissions
     */
    public function actionSetExecutable()
    {
        $this->setExecutable($this->executablePaths);
    }

    /**
     * @param $paths
     */
    private function setWritable($paths)
    {
        foreach ($paths as $writable) {
            $writable = Yii::getAlias($writable);
            Console::output("Setting writable: {$writable}");
            @chmod($writable, 0777);
        }
    }

    /**
     * @param $paths
     */
    private function setExecutable($paths)
    {
        foreach ($paths as $executable) {
            $executable = Yii::getAlias($executable);
            Console::output("Setting executable: {$executable}");
            @chmod($executable, 0755);
        }
    }

    /**
     * @param $paths
     */
    private function setKeys($paths)
    {
        foreach ($paths as $file) {
            $file = Yii::getAlias($file);
            Console::output("Generating keys in {$file}");
            $content = file_get_contents($file);
            $content = preg_replace_callback('/<generated_key>/', function () {
                $length = 32;
                $bytes = openssl_random_pseudo_bytes(32, $cryptoStrong);
                return strtr(substr(base64_encode($bytes), 0, $length), '+/', '_-');
            }, $content);
            file_put_contents($file, $content);
        }
    }
    
    public function setGenerateCharactersConfig($path) {
        
        $data = "<?php
    return [
        'components' => [
            'char_{realm_id from table realmlist DB -> auth}' => [
                //config yii/db/Connection
            ],
        ],
    ];";
        
        file_put_contents($path . 'base_characters.php', $data);
    }
    
}
