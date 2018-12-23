<?php

$config = [
    'homeUrl'             => Yii::getAlias('@apiUrl'),
    'controllerNamespace' => 'api\controllers',
    'defaultRoute'        => 'site/index',
    'bootstrap'           => ['maintenance'],
    'modules'             => [
        'v1' => \api\modules\v1\Module::class,
    ],
    'components' => [
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'maintenance' => [
            'class'   => core\components\maintenance\Maintenance::class,
            'enabled' => function ($app) {
                /** @var \BaseApplication $app */
                if ($app->TrinityWeb::isAppInstalled()) {
                    return $app->TrinityWeb::isAppMaintenanceMode();
                }

                return false;
            },
        ],
        'request' => [
            'enableCookieValidation' => false,
        ],
        'user' => [
            'class'           => yii\web\User::class,
            'identityClass'   => core\models\User::class,
            'loginUrl'        => ['/user/sign-in/login'],
            'enableAutoLogin' => true,
            'as afterLogin'   => core\behaviors\LoginTimestampBehavior::class,
        ],
    ],
];

return $config;
