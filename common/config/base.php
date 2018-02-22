<?php
$config = [
    'name' => 'RF-studio',
    'vendorPath' => __DIR__ . '/../../vendor',
    'extensions' => require(__DIR__ . '/../../vendor/yiisoft/extensions.php'),
    'sourceLanguage' => 'ru-RU',
    'language' => 'ru-RU',
    'bootstrap' => ['log','forum','translatemanager'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'modules' => [
        'forum' => [
            'class' => 'common\modules\forum\Podium',
            'userComponent' => 'user',
            'adminId' => 1,
            'allowedIPs' => [env('FORUM_INSTALLING_IP_ACCESS'),'::1'],
            'rbacComponent' => 'authManager',
            'cacheComponent' => 'cache',
            'userNameField' => 'username',
        ],
        'translatemanager' => [
            'class' => 'common\modules\i18n\Module',
            'root' => ['@frontend','@backend','@common','@console'],               // The root directory of the project scan.
            'scanRootParentDirectory' => true, // Whether scan the defined `root` parent directory, or the folder itself.
                                               // IMPORTANT: for detailed instructions read the chapter about root configuration.
            'layout' => '/main',         // Name of the used layout. If using own layout use 'null'.
            'allowedIPs' => ['*'],  // IP addresses from which the translation interface is accessible.
            'roles' => ['admin', 'interpreter', 'i18n_access'],               // For setting access levels to the translating interface.
            'tmpDir' => '@runtime',         // Writable directory for the client-side temporary language files.
                                            // IMPORTANT: must be identical for all applications (the AssetsManager serves the JavaScript files containing language elements from this directory).
            'phpTranslators' => ['::t'],    // list of the php function for translating messages.
            'jsTranslators' => ['lajax.t'], // list of the js function for translating messages.
            'patterns' => ['*.js', '*.php'],// list of file extensions that contain language elements.
            'ignoredCategories' => ['yii'], // these categories won't be included in the language database.
            'ignoredItems' => ['config'],   // these files will not be processed.
            'scanTimeLimit' => null,        // increase to prevent "Maximum execution time" errors, if null the default max_execution_time will be used
            'searchEmptyCommand' => '!',    // the search string to enter in the 'Translation' search field to find not yet translated items, set to null to disable this feature
            'defaultExportStatus' => 1,     // the default selection of languages to export, set to 0 to select all languages by default
            'defaultExportFormat' => 'json',// the default format for export, can be 'json' or 'xml'
            'tables' => [                   // Properties of individual tables
                [
                    'connection' => 'db',   // connection identifier
                    'table' => '{{%language}}',         // table name
                    'columns' => ['name', 'name_ascii'],// names of multilingual fields
                    'category' => 'database-table-name',// the category is the database table name
                ]
            ],
            'scanners' => [ // define this if you need to override default scanners (below)
                'common\modules\i18n\services\scanners\ScannerPhpFunction',
                'common\modules\i18n\services\scanners\ScannerPhpArray',
                'common\modules\i18n\services\scanners\ScannerJavaScriptFunction',
                'common\modules\i18n\services\scanners\ScannerDatabase',
            ],
        ],
    ],
    'controllerMap' => [
        'migrate' => [
            'class' => 'yii\console\controllers\MigrateController',
            'migrationNamespaces' => [
                'common\modules\i18n\migrations\namespaced',
            ],
        ],
    ],
    'components' => [
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            'itemTable' => '{{%rbac_auth_item}}',
            'itemChildTable' => '{{%rbac_auth_item_child}}',
            'assignmentTable' => '{{%rbac_auth_assignment}}',
            'ruleTable' => '{{%rbac_auth_rule}}'
        ],
        'CharactersDbHelper' => 'common\components\helpers\CharactersDbHelper',
        'AppHelper' => 'common\components\helpers\AppHelper',
        'cache' => [
            'class' => 'yii\caching\FileCache',
            'cachePath' => '@common/runtime/cache'
        ],
        'commandBus' => [
            'class' => 'trntv\bus\CommandBus',
            'middlewares' => [
                [
                    'class' => '\trntv\bus\middlewares\BackgroundCommandMiddleware',
                    'backgroundHandlerPath' => '@console/yii',
                    'backgroundHandlerRoute' => 'command-bus/handle',
                ]
            ]
        ],
        'formatter' => [
            'class' => 'yii\i18n\Formatter'
        ],
        'glide' => [
            'class' => 'trntv\glide\components\Glide',
            'sourcePath' => '@storage/web/source',
            'cachePath' => '@storage/cache',
            'urlManager' => 'urlManagerStorage',
            'maxImageSize' => env('GLIDE_MAX_IMAGE_SIZE'),
            'signKey' => env('GLIDE_SIGN_KEY')
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => env('SMTP_HOST'),
                'username' => env('SMTP_USERNAME'),
                'password' => env('SMTP_PASSWORD'),
                'port' => env('SMTP_PORT'),
                'encryption' => 'tls',
            ],
        ],
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => env('DB_DSN'),
            'username' => env('DB_USERNAME'),
            'password' => env('DB_PASSWORD'),
            'tablePrefix' => env('DB_TABLE_PREFIX'),
            'charset' => 'utf8',
            'enableSchemaCache' => YII_ENV_PROD,
        ],
        'auth' => [
            'class' => 'yii\db\Connection',
            'dsn' => env('AUTH_DB_DSN'),
            'username' => env('AUTH_DB_USERNAME'),
            'password' => env('AUTH_DB_PASSWORD'),
            'tablePrefix' => env('AUTH_DB_TABLE_PREFIX'),
            'charset' => 'utf8',
            'enableSchemaCache' => YII_ENV_PROD,
        ],
        'armory_db' => [
            'class' => 'yii\db\Connection',
            'dsn' => env('ARMORY_DB_DSN'),
            'username' => env('ARMORY_DB_USERNAME'),
            'password' => env('ARMORY_DB_PASSWORD'),
            'tablePrefix' => env('ARMORY_DB_TABLE_PREFIX'),
            'charset' => 'utf8',
            'enableSchemaCache' => YII_ENV_PROD,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                'db' => [
                    'class' => 'yii\log\DbTarget',
                    'levels' => ['error'],
                    'except' => ['yii\web\HttpException:*', 'yii\i18n\I18N\*'],
                    'prefix' => function () {
                        $url = !Yii::$app->request->isConsoleRequest ? Yii::$app->request->getUrl() : null;
                        return sprintf('[%s][%s]', Yii::$app->id, $url);
                    },
                    'logVars' => [],
                    'logTable' => '{{%system_log}}'
                ]
            ],
        ],
        'i18n' => [
            'translations' => [
                'app' => [
                    'class' => 'common\components\i18n\DbMessageSource',
                    'db' => 'db',
                    'sourceLanguage' => 'ru-RU',
                    'sourceMessageTable' => '{{%language_source}}',
                    'messageTable' => '{{%language_translate}}',
                    'cachingDuration' => 86400,
                    'enableCaching' => true,
                ],
                '*' => [
                    'class' => 'common\components\i18n\DbMessageSource',
                    'db' => 'db',
                    'sourceLanguage' => 'ru-RU',
                    'sourceMessageTable' => '{{%language_source}}',
                    'messageTable' => '{{%language_translate}}',
                    'cachingDuration' => 86400,
                    'enableCaching' => true,
                ],
            ],
        ],
        'fileStorage' => [
            'class' => '\trntv\filekit\Storage',
            'baseUrl' => '@storageUrl/source',
            'filesystem' => [
                'class' => 'common\components\filesystem\LocalFlysystemBuilder',
                'path' => '@storage/web/source'
            ],
            'as log' => [
                'class' => 'common\behaviors\FileStorageLogBehavior',
                'component' => 'fileStorage'
            ]
        ],
        'keyStorage' => [
            'class' => 'common\components\keyStorage\KeyStorage'
        ],
        'urlManagerBackend' => \yii\helpers\ArrayHelper::merge(
            [
                'hostInfo' => env('BACKEND_HOST_INFO'),
                'baseUrl' => env('BACKEND_BASE_URL'),
            ],
            require(Yii::getAlias('@backend/config/_urlManager.php'))
        ),
        'urlManagerFrontend' => \yii\helpers\ArrayHelper::merge(
            [
                'hostInfo' => env('FRONTEND_HOST_INFO'),
                'baseUrl' => env('FRONTEND_BASE_URL'),
            ],
            require(Yii::getAlias('@frontend/config/_urlManager.php'))
        ),
        'urlManagerStorage' => \yii\helpers\ArrayHelper::merge(
            [
                'hostInfo' => env('STORAGE_HOST_INFO'),
                'baseUrl' => env('STORAGE_BASE_URL'),
            ],
            require(Yii::getAlias('@storage/config/_urlManager.php'))
        )
    ],
    'params' => [
        'adminEmail' => env('ADMIN_EMAIL'),
        'robotEmail' => env('ROBOT_EMAIL'),
        'availableLocales' => [
            'en-US' => 'English (US)',
            'ru-RU' => 'Русский (РФ)',
            'uk-UA' => 'Українська (Україна)',
            'es-ES' => 'Español',
            'vi-VN' => 'Tiếng Việt',
            'zh-CN' => '简体中文',
            'pl-PL' => 'Polski (PL)',
            'pt-BR' => 'Portuguese',
        ],
    ],
];
                    
if (YII_ENV_PROD) {
    $config['components']['log']['targets']['email'] = [
        'class' => 'yii\log\EmailTarget',
        'except' => ['yii\web\HttpException:*'],
        'levels' => ['error', 'warning'],
        'message' => ['from' => env('ROBOT_EMAIL'), 'to' => env('ADMIN_EMAIL')]
    ];
}

if (YII_ENV_DEV) {
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module'
    ];
    $config['components']['mailer']['transport'] = [
        'class' => 'Swift_SmtpTransport',
        'host' => env('SMTP_HOST'),
        'port' => env('SMTP_PORT'),
    ];
}

return $config;
