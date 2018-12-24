<?php
$config = [
    'name'           => 'TrinityWeb',
    'vendorPath'     => __DIR__ . '/../../vendor',
    'extensions'     => require(__DIR__ . '/../../vendor/yiisoft/extensions.php'),
    'sourceLanguage' => 'en-US',
    'language'       => 'en-US',
    'bootstrap'      => ['translatemanager'],
    'aliases'        => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'modules' => [
        'translatemanager' => [
            'class'                   => 'core\modules\i18n\Module',
            'root'                    => ['@frontend','@backend','@core','@console', '@api'],
            'scanRootParentDirectory' => true,
            'layout'                  => '/main',
            'allowedIPs'              => ['*'],
            'roles'                   => [\core\components\helpers\PermissionHelper::ACCESS_GLOBAL_i18n],
            'tmpDir'                  => '@runtime',
            'phpTranslators'          => ['::t'],
            'jsTranslators'           => ['lajax.t'],
            'patterns'                => ['*.js', '*.php'],
            'ignoredCategories'       => ['yii'],
            'ignoredItems'            => ['config'],
            'scanTimeLimit'           => null,
            'searchEmptyCommand'      => '!',
            'defaultExportStatus'     => 1,
            'defaultExportFormat'     => 'json',
            'tables'                  => [
                [
                    'connection' => 'db',
                    'table'      => '{{%language}}',
                    'columns'    => ['name', 'name_ascii'],
                    'category'   => 'database-table-name',
                ]
            ],
            'scanners' => [
                'core\modules\i18n\services\scanners\ScannerPhpFunction',
                'core\modules\i18n\services\scanners\ScannerPhpArray',
                'core\modules\i18n\services\scanners\ScannerJavaScriptFunction',
                'core\modules\i18n\services\scanners\ScannerDatabase',
            ],
        ]
    ],
    'components' => [
        'SeoHelper' => [
            'class' => \core\components\helpers\SeoHelper::class
        ],

        'settings' => [
            'class' => \core\components\settings\Settings::class
        ],

        'PermissionHelper' => [
            'class' => \core\components\helpers\PermissionHelper::class
        ],

        'i18nHelper' => [
            'class' => \core\components\helpers\i18nHelper::class
        ],

        'TrinityWeb' => [
            'class' => \core\components\helpers\TrinityWeb::class
        ],

        'DBHelper' => [
            'class' => \core\components\helpers\DBHelper::class
        ],

        'LogHelper' => [
            'class' => \core\components\logs\Log::class
        ],

        'armoryHelper' => [
            'class' => \core\components\helpers\Armory::class
        ],

        'authManager' => [
            'class'           => yii\rbac\DbManager::class,
            'itemTable'       => '{{%rbac_auth_item}}',
            'itemChildTable'  => '{{%rbac_auth_item_child}}',
            'assignmentTable' => '{{%rbac_auth_assignment}}',
            'ruleTable'       => '{{%rbac_auth_rule}}',
            'cache' => 'cache',
        ],

        'commandBus' => [
            'class'       => trntv\bus\CommandBus::class,
            'middlewares' => [
                [
                    'class'                  => trntv\bus\middlewares\BackgroundCommandMiddleware::class,
                    'backgroundHandlerPath'  => '@console/yii',
                    'backgroundHandlerRoute' => 'command-bus/handle',
                ]
            ]
        ],

        'formatter' => [
            'class' => yii\i18n\Formatter::class
        ],

        'glide' => [
            'class'        => trntv\glide\components\Glide::class,
            'sourcePath'   => '@storage/web/source',
            'cachePath'    => '@storage/cache',
            'urlManager'   => 'urlManagerStorage',
            'maxImageSize' => env('GLIDE_MAX_IMAGE_SIZE'),
            'signKey'      => env('GLIDE_SIGN_KEY')
        ],

        'fileStorage' => [
            'class'      => trntv\filekit\Storage::class,
            'baseUrl'    => '@storageUrl/source',
            'filesystem' => [
                'class' => core\components\filesystem\LocalFlysystemBuilder::class,
                'path'  => '@storage/web/source'
            ],
            'as log' => [
                'class'     => core\behaviors\FileStorageLogBehavior::class,
                'component' => 'fileStorage'
            ]
        ],

        'urlManagerBackend' => \yii\helpers\ArrayHelper::merge(
            [
                'hostInfo' => env('BACKEND_HOST_INFO'),
                'baseUrl'  => env('BACKEND_BASE_URL'),
            ],
            require(Yii::getAlias('@backend/config/_urlManager.php'))
        ),
        'urlManagerFrontend' => \yii\helpers\ArrayHelper::merge(
            [
                'hostInfo' => env('FRONTEND_HOST_INFO'),
                'baseUrl'  => env('FRONTEND_BASE_URL'),
            ],
            require(Yii::getAlias('@frontend/config/_urlManager.php'))
        ),
        'urlManagerStorage' => \yii\helpers\ArrayHelper::merge(
            [
                'hostInfo' => env('STORAGE_HOST_INFO'),
                'baseUrl'  => env('STORAGE_BASE_URL'),
            ],
            require(Yii::getAlias('@storage/config/_urlManager.php'))
        ),
        'urlManagerApi' => \yii\helpers\ArrayHelper::merge(
            [
                'hostInfo' => env('API_HOST_INFO'),
                'baseUrl'  => env('API_BASE_URL'),
            ],
            require(Yii::getAlias('@api/config/_urlManager.php'))
        ),

        'queue' => [
            'class' => \yii\queue\file\Queue::class,
            'path'  => '@core/runtime/queue',
        ],

        'cache' => [
            'class'     => yii\caching\FileCache::class,
            'cachePath' => '@core/runtime/cache'
        ],
    ],
    'params' => [
        'bsVersion' => '4.1.1',
        //'bsDependencyEnabled' => false
    ],
];

if(file_exists(__DIR__ . '/app/database-web.php')) {
    $config = \yii\helpers\ArrayHelper::merge($config,require('app/database-web.php'));
}

if(file_exists(__DIR__ . '/app/database-auth.php')) {
    $config = \yii\helpers\ArrayHelper::merge($config,require('app/database-auth.php'));
}

if(file_exists(__DIR__ . '/app/database-characters.php')) {
    $config = \yii\helpers\ArrayHelper::merge($config,require('app/database-characters.php'));
}

if(file_exists(__DIR__ . '/app/components.php')) {
    $config = \yii\helpers\ArrayHelper::merge($config,require('app/components.php'));
}

if(file_exists(__DIR__ . '/app/mailer.php')) {
    $config = \yii\helpers\ArrayHelper::merge($config,require('app/mailer.php'));
}

if (YII_ENV_DEV) {
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => yii\gii\Module::class
    ];
}

return $config;
