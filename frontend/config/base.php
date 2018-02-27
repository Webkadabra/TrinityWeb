<?php
return [
    'id' => 'frontend',
    'basePath' => dirname(__DIR__),
    'components' => [
        'urlManager' => require(__DIR__ . '/_urlManager.php'),
        'cache' => require(__DIR__ . '/_cache.php'),
        
        'freeKassa' => [
            'class' => 'frontend\components\freeKassa\Merchant',
            'merchantId' => env('FREEKASSA_MERCHANT_ID'),
            'merchantFormSecret' => env('FREEKASSA_FORM_SECRET'),
            'checkDataSecret' => env('FREEKASSA_DATA_SECRET'),
            'defaultCurrency' => env('FREEKASSA_DEFAULT_CURRENCY'),
            'defaultLanguage' => 'ru'
        ]
    ],
];
