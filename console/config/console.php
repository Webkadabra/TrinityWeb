<?php
return [
    'id'                  => 'console',
    'basePath'            => dirname(__DIR__),
    'controllerNamespace' => 'console\controllers',
    'components'          => [
        'frontendCache' => require Yii::getAlias('@frontend/config/_cache.php'),
        'apiCache'      => require Yii::getAlias('@api/config/_cache.php')
    ],
    'controllerMap' => [
        'command-bus' => [
            'class' => trntv\bus\console\BackgroundBusController::class,
        ],
        'migrate' => [
            'class'         => yii\console\controllers\MigrateController::class,
            'migrationPath' => [
                '@console/migrations/i18n',
                '@console/migrations/db',
            ],
            'migrationTable' => '{{%system_db_migration}}'
        ],
        'rbac-migrate' => [
            'class'          => console\base\controllers\RbacMigrateController::class,
            'migrationPath'  => '@console/migrations/rbac/',
            'migrationTable' => '{{%system_rbac_migration}}',
            'templateFile'   => '@core/rbac/views/migration.php'
        ],
    ],
];
