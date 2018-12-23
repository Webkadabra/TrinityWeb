<?php
$config = [
    'components' => [
        'assetManager' => [
            'class'           => yii\web\AssetManager::class,
            'linkAssets'      => env('LINK_ASSETS'),
            'appendTimestamp' => YII_ENV_DEV
        ]
    ],
    'as locale' => [
        'class'                   => core\behaviors\LocaleBehavior::class,
        'enablePreferredLanguage' => true
    ],
    'bootstrap' => ['install','treemanager'],
    'modules'   => [
        'install' => [
            'class' => core\modules\installer\ModuleInstall::class
        ],
        'treemanager' => [
            'class' => \kartik\tree\Module::class,
        ],
    ]
];

if (YII_DEBUG) {
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class'      => yii\debug\Module::class,
        'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

if (YII_ENV_DEV) {
    $config['modules']['gii'] = [
        'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
