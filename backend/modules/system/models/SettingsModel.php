<?php

namespace backend\modules\system\models;

use core\base\models\AuthCoreModel;
use core\base\models\CharacterCoreModel;
use core\models\Server;
use core\modules\installer\helpers\Configuration;
use Yii;
use yii\base\Exception;
use yii\base\InvalidConfigException;
use yii\base\Model;
use yii\db\Connection;
use yii\web\NotFoundHttpException;

/**
 * Class SettingsModel
 * @package backend\modules\system\models
 */
class SettingsModel extends Model
{
    /**
     * @var string
     */
    public $application_name;
    /**
     * @var string
     */
    public $application_announce;

    /**
     * @var
     */
    public $application_maintenance;

    /**
     * @var
     */
    public $application_theme;

    /**
     * @var
     */
    public $recaptcha_status;
    /**
     * @var
     */
    public $recaptcha_key;
    /**
     * @var
     */
    public $recaptcha_secret;

    /**
     * @var
     */
    public $mailer_admin;
    /**
     * @var
     */
    public $mailer_robot;

    /**
     * @var
     */
    public $modules;

    /**
     * @var array auth_dbs
     */
    public $auth_dbs = [];

    /**
     * @var array char_dbs
     */
    public $char_dbs = [];

    /**
     * SettingsModel constructor.
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        $this->application_name = Yii::$app->settings->get(Yii::$app->settings::APP_NAME);
        $this->application_announce = Yii::$app->settings->get(Yii::$app->settings::APP_ANNOUNCE);

        $this->application_maintenance = Yii::$app->settings->get(Yii::$app->settings::APP_MAINTENANCE) === Yii::$app->settings::ENABLED ? 1 : 0;
        $this->application_theme = Yii::$app->settings->get(Yii::$app->settings::APP_THEME);

        $this->recaptcha_status = Yii::$app->settings->get(Yii::$app->settings::APP_CAPTCHA_STATUS) === Yii::$app->settings::ENABLED ? 1 : 0;
        $this->recaptcha_key = Yii::$app->settings->get(Yii::$app->settings::APP_CAPTCHA_KEY);
        $this->recaptcha_secret = Yii::$app->settings->get(Yii::$app->settings::APP_CAPTCHA_SECRET);

        $this->mailer_admin = Yii::$app->settings->get(Yii::$app->settings::APP_MAILER_ADMIN);
        $this->mailer_robot = Yii::$app->settings->get(Yii::$app->settings::APP_MAILER_ROBOT);

        $this->modules = [];
        $this->modules = [
            'ladder' => [
                'label'      => Yii::t('backend','Ladder'),
                'field_keys' => [
                    'status'         => Yii::$app->settings::APP_MODULE_LADDER_STATUS,
                    'per-page'       => Yii::$app->settings::APP_MODULE_LADDER_PER_PAGE,
                    'cache_duration' => Yii::$app->settings::APP_MODULE_LADDER_CACHE_DURATION,
                ],
                'fields' => [
                    'status'         => Yii::$app->settings->get(Yii::$app->settings::APP_MODULE_LADDER_STATUS) === Yii::$app->settings::ENABLED ? 1 : 0,
                    'per-page'       => Yii::$app->settings->get(Yii::$app->settings::APP_MODULE_LADDER_PER_PAGE),
                    'cache_duration' => Yii::$app->settings->get(Yii::$app->settings::APP_MODULE_LADDER_CACHE_DURATION)
                ],
                'description' => 'Module "Ladder" will show arena team statistics per realm'
            ],
            'forum' => [
                'label'      => Yii::t('backend','Forum'),
                'field_keys' => [
                    'status' => Yii::$app->settings::APP_MODULE_FORUM_STATUS
                ],
                'fields' => [
                    'status' => Yii::$app->settings->get(Yii::$app->settings::APP_MODULE_FORUM_STATUS) === Yii::$app->settings::ENABLED ? 1 : 0,
                ],
                'description' => 'Модуль "Форум"'
            ],
            /*'armory' => [
                'label' => Yii::t('backend','Armory'),
                'field_keys' => [
                    'status' => Yii::$app->TW::MODULE_ARMORY_STATUS,
                    'per-page' => Yii::$app->TW::MODULE_ARMORY_PER_PAGE,
                    'cache_duration' => Yii::$app->TW::MODULE_ARMORY_CACHE_DURATION,
                ],
                'fields' => [
                    'status' => Yii::$app->settings->get(Yii::$app->TW::MODULE_ARMORY_STATUS) == Yii::$app->TW::ENABLED ? 1 : 0,
                    'per-page' => Yii::$app->settings->get(Yii::$app->TW::MODULE_ARMORY_PER_PAGE),
                    'cache_duration' => Yii::$app->settings->get(Yii::$app->TW::MODULE_ARMORY_CACHE_DURATION)
                ],
                'description' => 'Модуль "Армори", который позволяет просматривать персонажа (хар-ки,вещи, последние достижения, таланты, команды арен)'
            ],
            'bugtracker' => [
                'label' => Yii::t('backend','BugTracker'),
                'field_keys' => [
                    'status' => Yii::$app->TW::MODULE_BUGTRACKER_STATUS
                ],
                'fields' => [
                    'status' => Yii::$app->settings->get(Yii::$app->TW::MODULE_BUGTRACKER_STATUS) == Yii::$app->TW::ENABLED ? 1 : 0
                ],
                'description' => 'Модуль "БагТрекер" - позволяет пользователям оставлять ошибки'
            ]*/
        ];

        $this->setSystemDatabaseConnections();

        parent::__construct($config);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['application_name', 'application_announce'],'string'],
            [['application_name'],'string', 'max' => 32],
            [['recaptcha_status', 'application_maintenance'],'boolean'],
            [['mailer_robot','mailer_admin'],'string', 'max' => 32],
            [['application_theme'],'string', 'max' => 255],
            [['recaptcha_secret','recaptcha_key'],'string', 'max' => 64],
            [['modules','auth_dbs','char_dbs'],'safe']
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'application_name'        => Yii::t('backend','Application name'),
            'application_maintenance' => Yii::t('backend','Application Maintenance'),
            'application_announce'    => Yii::t('backend','Application Announce')
        ];
    }

    /**
     * @param $postData
     * @return bool
     */
    public function save($postData)
    {
        if($this->load($postData) && $this->validate()) {
            Yii::$app->settings->set(Yii::$app->settings::APP_NAME, $this->application_name);
            Yii::$app->settings->set(Yii::$app->settings::APP_ANNOUNCE, $this->application_announce);

            Yii::$app->settings->set(Yii::$app->settings::APP_MAILER_ROBOT, $this->mailer_robot);
            Yii::$app->settings->set(Yii::$app->settings::APP_MAILER_ADMIN, $this->mailer_admin);
            Yii::$app->settings->set(Yii::$app->settings::APP_THEME, $this->application_theme);

            if($this->recaptcha_status && $this->recaptcha_key && $this->recaptcha_secret) {
                Yii::$app->settings->set(Yii::$app->settings::APP_CAPTCHA_STATUS,Yii::$app->settings::ENABLED);
                Yii::$app->settings->set(Yii::$app->settings::APP_CAPTCHA_KEY,$this->recaptcha_key);
                Yii::$app->settings->set(Yii::$app->settings::APP_CAPTCHA_SECRET,$this->recaptcha_secret);
            } else {
                Yii::$app->settings->set(Yii::$app->settings::APP_CAPTCHA_STATUS,Yii::$app->settings::DISABLED);
                if((!$this->recaptcha_key || !$this->recaptcha_secret) && $this->recaptcha_status) {
                    Yii::$app->session->setFlash('warning', Yii::t('backend', 'конфигурация для reCaptcha неправильная. Установлен статус - выключена'));
                }
            }

            Yii::$app->settings->set(
                Yii::$app->settings::APP_MAINTENANCE,
                $this->application_maintenance ?
                    Yii::$app->settings::ENABLED : Yii::$app->settings::DISABLED
            );

            if($modulesData = $postData['Module']) {
                foreach ($this->modules as $key => $module) {
                    if(isset($modulesData[$key])) {
                        if(isset($modulesData[$key]['status'])) {
                            Yii::$app->settings->set($module['field_keys']['status'],Yii::$app->settings::ENABLED);
                        } else {
                            Yii::$app->settings->set($module['field_keys']['status'],Yii::$app->settings::DISABLED);
                        }
                        if(isset($modulesData[$key]['per-page'])) {
                            if($modulesData[$key]['per-page']) Yii::$app->settings->set($module['field_keys']['per-page'],$modulesData[$key]['per-page']);
                        }
                        if(isset($modulesData[$key]['cache_duration'])) {
                            if($modulesData[$key]['cache_duration']) Yii::$app->settings->set($module['field_keys']['cache_duration'],$modulesData[$key]['cache_duration']);
                        }
                    }
                }
            }

            return true;
        }

        return false;
    }

    public function loadAuthDbs($dbs) {
        if(!$dbs) return false;
        $this->auth_dbs = [];
        foreach($dbs as $index => $db) {
            $this->auth_dbs[$index] = new AuthDatabases($db);
        }

        return true;
    }

    public function loadCharDbs($dbs) {
        if(!$dbs) return false;
        $this->char_dbs = [];
        foreach($dbs as $db) {
            $this->char_dbs[] = new CharDatabases($db);
        }

        return true;
    }

    /**
     * @throws \yii\base\InvalidConfigException
     * @return array
     */
    public function saveAuthConnections()
    {
        $errorMsg = [];
        $config = [];
        foreach($this->auth_dbs as $index => $db) {
            $key_name = "auth_$index";
            $dsn = "mysql:host=" . $db['host'] . ";port=" . $db['port'] . ";dbname=" . $db['database'];
            Yii::$app->set($key_name, [
                'class'    => Connection::class,
                'dsn'      => $dsn,
                'username' => $db['login'],
                'password' => $db['password'],
                'charset'  => 'utf8'
            ]);
            try {
                $err = Yii::$app->TrinityWeb::checkDBConnection($key_name);
                if ($err === true) {
                    $config['components'][$key_name]['class'] = Connection::class;
                    $config['components'][$key_name]['dsn'] = $dsn;
                    $config['components'][$key_name]['username'] = $db['login'];
                    $config['components'][$key_name]['password'] = $db['password'];
                    $config['components'][$key_name]['charset'] = 'utf8';
                    $config['components'][$key_name]['enableSchemaCache'] = true;
                } else {
                    $errorMsg[$key_name] = Yii::t('installer','Connection {host}:{port} to {database} return with error {err}',[
                        'host'     => $db['host'],
                        'port'     => $db['port'],
                        'database' => $db ['database'],
                        'err'      => $err instanceof \Exception ? $err->getMessage() : null
                    ]);
                }
            } catch (\Exception $e) {
                $errorMsg[$key_name] = $e->getMessage();
            }
        }

        if(!$errorMsg && !empty($config)) {
            Configuration::setConfig(Yii::getAlias('@core/config/app/database-auth.php'), $config);
        }

        return $errorMsg;
    }

    /**
     * @throws \yii\base\InvalidConfigException
     * @return array
     */
    public function saveCharConnections()
    {
        $errorMsg = [];
        $config = [];
        foreach($this->char_dbs as $index => $db) {
            $key_name = $db['name'];
            $dsn = "mysql:host=" . $db['host'] . ";port=" . $db['port'] . ";dbname=" . $db['database'];
            Yii::$app->set($key_name, [
                'class'    => Connection::class,
                'dsn'      => $dsn,
                'username' => $db['login'],
                'password' => $db['password'],
                'charset'  => 'utf8'
            ]);
            try {
                $err = Yii::$app->TrinityWeb::checkDBConnection($key_name);
                if ($err === true) {
                    $config['components'][$key_name]['class'] = Connection::class;
                    $config['components'][$key_name]['dsn'] = $dsn;
                    $config['components'][$key_name]['username'] = $db['login'];
                    $config['components'][$key_name]['password'] = $db['password'];
                    $config['components'][$key_name]['charset'] = 'utf8';
                    $config['components'][$key_name]['enableSchemaCache'] = true;
                } else {
                    $errorMsg[$key_name] = Yii::t('installer','Connection {host}:{port} to {database} return with error {err}',[
                        'host'     => $db['host'],
                        'port'     => $db['port'],
                        'database' => $db ['database'],
                        'err'      => $err instanceof \Exception ? $err->getMessage() : null
                    ]);
                }
            } catch (\Exception $e) {
                $errorMsg[$key_name] = $e->getMessage();
            }
        }

        if(!$errorMsg && !empty($config)) {
            Configuration::setConfig(Yii::getAlias('@core/config/app/database-characters.php'), $config);
        }

        return $errorMsg;
    }

    private function setSystemDatabaseConnections()
    {
        $servers = Yii::$app->DBHelper->getServers();
        $char_key = 0;
        foreach($servers as $server) {
            /* @var Server $server */
            if(!isset($this->auth_dbs[$server['auth_id']])) {
                $auth_connection = AuthCoreModel::getDb($server['auth_id']);
                $auth_dsnConfig = $this->parseDSN($auth_connection->dsn);
                if($auth_dsnConfig) {
                    $this->auth_dbs[$server['auth_id']] = new AuthDatabases([
                        'host'         => $auth_dsnConfig['host'],
                        'port'         => $auth_dsnConfig['port'],
                        'database'     => $auth_dsnConfig['dbname'],
                        'login'        => $auth_connection->username,
                        'password'     => $auth_connection->password,
                        'table_prefix' => $auth_connection->tablePrefix
                    ]);
                }
            }
            try {
                $char_connection = CharacterCoreModel::getDb($server['auth_id'], $server['realm_id']);

                $char_dsnConfig = $this->parseDSN($char_connection->dsn);
                if($char_dsnConfig) {
                    $this->char_dbs[$char_key++] = new CharDatabases([
                        'name'         => "char_{$server['auth_id']}_{$server['realm_id']}",
                        'host'         => $char_dsnConfig['host'],
                        'port'         => $char_dsnConfig['port'],
                        'database'     => $char_dsnConfig['dbname'],
                        'login'        => $char_connection->username,
                        'password'     => $char_connection->password,
                        'table_prefix' => $char_connection->tablePrefix
                    ]);
                }
            } catch (InvalidConfigException $e) {
            } catch (NotFoundHttpException $e) {
            } catch (Exception $e) {
            }
        }
    }

    private function parseDSN($dsn)
    {
        $exploded = array_map(
            function ($_var) {
                return explode('=', $_var);
            },
            explode(';', $dsn)
        );
        $parseArray = [];
        if (count($exploded) > 1) {
            foreach ($exploded as $index => $element) {
                if(strpos($element[0],'host') !== false) {
                    $parseArray['host'] = $element[1];
                } else {
                    $parseArray[$element[0]] = $element[1];
                }
            }
        }

        return $parseArray;
    }
}
