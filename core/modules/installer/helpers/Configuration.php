<?php
namespace core\modules\installer\helpers;

use Yii;
use yii\db\Connection;

class Configuration
{
    /**
     * Sets params into the file
     *
     * @param array $config
     * @param mixed $file
     */
    public static function setConfig($file, $config = [])
    {
        $content = "<" . "?php return ";
        $content .= var_export($config, TRUE);
        $content .= "; ?" . ">";
        file_put_contents($file, $content);
        if (function_exists('opcache_reset')) {
            opcache_invalidate($file);
        }
    }

    /**
     * Checks if database connections works
     * @param string $db_component
     * @return boolean
     */
    public static function checkDbConnection($db_component = 'db')
    {
        try {
            Yii::$app->{$db_component}->isActive;

            return true;
        } catch (Exception $e) {
            return $e->getMessage();
        }

        return false;
    }

    public static function buildConfigurationDatabase($model, $component_key)
    {
        $errorMsg = null;
        $config = [];
        $dsn = "mysql:host=" . $model['host'] . ";port=" . $model['port'] . ";dbname=" . $model['database'];
        Yii::$app->set($component_key, [
            'class'       => Connection::class,
            'dsn'         => $dsn,
            'username'    => $model['login'],
            'password'    => $model['password'],
            'tablePrefix' => $model['table_prefix'],
            'charset'     => 'utf8'
        ]);
        try {
            Yii::$app->{$component_key}->open();
            if (static::checkDbConnection($component_key)) {
                $config['components'][$component_key]['class'] = Connection::class;
                $config['components'][$component_key]['dsn'] = $dsn;
                $config['components'][$component_key]['username'] = $model['login'];
                $config['components'][$component_key]['password'] = $model['password'];
                $config['components'][$component_key]['tablePrefix'] = $model['table_prefix'];
                $config['components'][$component_key]['charset'] = 'utf8';
                $config['components'][$component_key]['enableSchemaCache'] = true;
            } else {
                $errorMsg = 'Incorrect configuration';
            }
        } catch (Exception $e) {
            $errorMsg = $e->getMessage();
        }

        return ['config' => $config, 'error' => $errorMsg];
    }

    public static function initConfigForComponents() {
        $components_config = '<?php return [
    "components" => [
        "i18n" => [
            "translations" => [
                "app" => [
                    "class" => "core\components\i18n\DbMessageSource",
                    "db" => "db",
                    "sourceLanguage" => "en-US",
                    "sourceMessageTable" => "{{%language_source}}",
                    "messageTable" => "{{%language_translate}}",
                    "cachingDuration" => 86400,
                    "enableCaching" => true,
                ],
                "*" => [
                    "class" => "core\components\i18n\DbMessageSource",
                    "db" => "db",
                    "sourceLanguage" => "en-US",
                    "sourceMessageTable" => "{{%language_source}}",
                    "messageTable" => "{{%language_translate}}",
                    "cachingDuration" => 86400,
                    "enableCaching" => true,
                ],
            ],
        ],
        "log" => [
            "traceLevel" => YII_DEBUG ? 3 : 0,
            "targets" => [
                "db" => [
                    "class" => "core\components\logs\LogsDbTarget",
                    "levels" => ["error", "warning"],
                    "except" => ["yii\web\HttpException:*", "yii\i18n\I18N\*"],
                    "prefix" => function () {
                        $url = !Yii::$app->request->isConsoleRequest ? Yii::$app->request->getUrl() : null;
                        return sprintf("[%s][%s]", Yii::$app->id, $url);
                    },
                    "logVars" => [],
                    "logTable" => "{{%logs}}"
                ]
            ],
        ],
    ],
];';
        file_put_contents(Yii::getAlias('@core/config/app/components.php'), $components_config);
    }
}