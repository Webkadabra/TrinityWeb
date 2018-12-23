<?php

$config = [
    'homeUrl'             => Yii::getAlias('@backendUrl'),
    'controllerNamespace' => 'backend\controllers',
    'defaultRoute'        => 'timeline-event/index',
    'components'          => [
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'request' => [
            'cookieValidationKey' => env('BACKEND_COOKIE_VALIDATION_KEY'),
            'baseUrl'             => env('BACKEND_BASE_URL'),
        ],
        'user' => [
            'class'           => yii\web\User::class,
            'identityClass'   => core\models\User::class,
            'loginUrl'        => ['sign-in/login'],
            'enableAutoLogin' => true,
            'as afterLogin'   => core\behaviors\LoginTimestampBehavior::class,
        ],
    ],
    'bootstrap' => ['content', 'widget', 'rbac', 'system', 'seo', 'forum'],
    'modules'   => [
        'content' => [
            'class' => backend\modules\content\Module::class,
        ],
        'widget' => [
            'class' => backend\modules\widget\Module::class,
        ],
        'file' => [
            'class' => backend\modules\file\Module::class,
        ],
        'system' => [
            'class' => backend\modules\system\Module::class,
        ],
        'rbac' => [
            'class' => backend\modules\rbac\Module::class,
        ],
        'seo' => [
            'class' => backend\modules\seo\Module::class,
        ],
        'forum' => [
            'class'          => \core\modules\forum\Podium::class,
            'userComponent'  => 'user',
            'rbacComponent'  => 'authManager',
            'cacheComponent' => 'cache',
            'userNameField'  => 'username',
            'layout'         => 'common',
            'layoutPath'     => '@backend/views/layouts',
        ],
    ],
];

if (YII_ENV_DEV) {
    $config['modules']['gii'] = [
        'class'      => yii\gii\Module::class,
        'generators' => [
            'crud' => [
                'class'     => yii\gii\generators\crud\Generator::class,
                'templates' => [
                    'yii2-starter-kit' => Yii::getAlias('@backend/views/_gii/templates'),
                ],
                'template'        => 'yii2-starter-kit',
                'messageCategory' => 'backend',
            ],
        ],
    ];
}

return $config;
