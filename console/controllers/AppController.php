<?php

namespace console\controllers;

use core\models\auth\Realmlist;
use core\models\Server;
use Yii;
use yii\base\Exception;
use yii\console\Controller;
use yii\helpers\Console;
use yii\helpers\Inflector;

class AppController extends Controller
{
    /** @var array */
    public $writablePaths = [
        '@api/runtime',
        '@api/web/assets',
        '@backend/runtime',
        '@backend/web/assets',
        '@console/runtime',
        '@core/config/app',
        '@core/runtime',
        '@frontend/runtime',
        '@frontend/web/assets',
        '@storage/cache',
        '@storage/web/source',
    ];

    /** @var array */
    public $generateKeysPaths = [
        '@base/.env'
    ];

    /** @var array */
    public $executablePaths = [
        '@console/yii',
    ];

    /**
     * Sets given keys to .env file
     */
    public function actionSetKeys()
    {
        $this->setKeys($this->generateKeysPaths);
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
            $tables = Yii::$app->db->schema->getTableNames();
            foreach ($tables as $table) {
                $this->stdout('Truncating table ' . $table . PHP_EOL, Console::FG_RED);
                Yii::$app->db->createCommand()->truncateTable($table)->execute();
            }
            Yii::$app->db->createCommand('SET FOREIGN_KEY_CHECKS=1')->execute();
        }
        Console::output('All tables are truncated!');
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
        Console::output('All tables are dropped!');
    }

    /**
     * @param string $charset
     * @param string $collation
     * @throws \yii\base\ExitException
     * @throws \yii\base\NotSupportedException
     * @throws \yii\db\Exception
     */
    public function actionAlterCharset($charset = 'utf8mb4', $collation = 'utf8mb4_unicode_ci')
    {
        if (Yii::$app->db->getDriverName() !== 'mysql') {
            Console::error('Only mysql is supported');
            Yii::$app->end(1);
        }

        if (!$this->confirm("Convert tables to character set {$charset}?")) {
            Yii::$app->end();
        }

        $tables = Yii::$app->db->getSchema()->getTableNames();
        Yii::$app->db->createCommand('SET FOREIGN_KEY_CHECKS = 0')->execute();
        foreach ($tables as $table) {
            /** @noinspection MissedParamInspection */
            $command = Yii::$app->db->createCommand("ALTER TABLE {$table} CONVERT TO CHARACTER SET :charset COLLATE :collation")->bindValues([
                ':charset'   => $charset,
                ':collation' => $collation
            ]);
            $command->execute();
        }
        Yii::$app->db->createCommand('SET FOREIGN_KEY_CHECKS = 1')->execute();
        Console::output('All ok!');
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
     * @throws Exception
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\db\Exception
     */
    public function actionSyncServers()
    {
        $configPath = Yii::getAlias('@core/config') . '/app/database-auth.php';
        if(file_exists($configPath)) {
            $config = require($configPath);
        } else {
            throw new Exception("File with connections to auth databases doesnt exist");
        }
        if(!empty($config)) {
            Yii::$app->db->createCommand()->truncateTable(Server::tableName())->execute();
            foreach($config['components'] as $auth_key => $configuration) {
                if(Yii::$app->TrinityWeb::checkDBConnection($auth_key) === true) {
                    $auth_id = str_replace('auth_','',$auth_key);
                    Realmlist::setDb(Yii::$app->get($auth_key));
                    $realms = Realmlist::find()->all();
                    if($realms) {
                        foreach ($realms as $key => $realm) {
                            /* @var \core\models\auth\Realmlist $realm */
                            $slug = Inflector::slug($realm->name);
                            $serverModel = Server::find()->where([
                                'auth_id'    => $auth_id,
                                'realm_id'   => $realm->id,
                                'realm_slug' => $slug
                            ])->one();
                            if(!$serverModel) {
                                $serverModel = new Server([
                                    'auth_id'            => $auth_id,
                                    'realm_id'           => $realm->id,
                                    'realm_name'         => $realm->name,
                                    'realm_slug'         => $slug,
                                    'realm_address'      => $realm->address,
                                    'realm_localAddress' => $realm->localAddress,
                                    'realm_port'         => $realm->port,
                                    'realm_build'        => $realm->gamebuild,
                                ]);
                            }
                            $serverModel->save();
                        }
                    }
                } else {
                    Console::error("Data from connection {$auth_key} not parsed. Check configuration!");
                }
            }
            Console::output("All servers are parsed");
        } else {
            throw new Exception("File with connections to auth databases doesnt exist");
        }
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
}