<?php
$config = [
    'homeUrl'             => Yii::getAlias('@frontendUrl'),
    'controllerNamespace' => 'frontend\controllers',
    'defaultRoute'        => 'main/index',
    'bootstrap'           => [
        'translatemanager',
        'maintenance',
        'profile',
        'ladder',
        'armory',
        'forum',
    ],
    'modules' => [
        'profile' => [
            'class' => \frontend\modules\profile\Module::class
        ],
        'ladder' => [
            'class' => \frontend\modules\ladder\Module::class
        ],
        'armory' => [
            'class' => \frontend\modules\armory\Module::class
        ],
        'forum' => [
            'class'          => \core\modules\forum\Podium::class,
            'userComponent'  => 'user',
            'rbacComponent'  => 'authManager',
            'cacheComponent' => 'cache',
            'userNameField'  => 'username',
            'layout'         => 'main-forum',
            'layoutPath'     => '@frontend/views/layouts',
        ],
    ],
    'components' => [
        'errorHandler' => [
            'errorAction' => 'main/error'
        ],
        'maintenance' => [
            'class'   => core\components\maintenance\Maintenance::class,
            'enabled' => function ($app) {
                /* @var BaseApplication $app */
                if($app->TrinityWeb::isAppInstalled()) {
                    return $app->TrinityWeb::isAppMaintenanceMode();
                }

                return false;
            }
        ],
        'request' => [
            'cookieValidationKey' => env('FRONTEND_COOKIE_VALIDATION_KEY')
        ],
        'user' => [
            'class'           => yii\web\User::class,
            'identityClass'   => core\models\User::class,
            'loginUrl'        => ['/auth/sign-in'],
            'enableAutoLogin' => true,
            'as afterLogin'   => core\behaviors\LoginTimestampBehavior::class
        ],
        'view' => [
            'theme' => [
                'class' => \frontend\components\Theme::class
            ],
        ]
    ]
];

if (YII_ENV_DEV) {
    $config['modules']['gii'] = [
        'class'      => yii\gii\Module::class,
        'generators' => [
            'crud' => [
                'class'           => yii\gii\generators\crud\Generator::class,
                'messageCategory' => 'frontend'
            ]
        ]
    ];
}

return $config;
