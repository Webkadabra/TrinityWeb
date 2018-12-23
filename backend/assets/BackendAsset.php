<?php

namespace backend\assets;

use core\assets\GlyphIcons;
use core\assets\Html5shiv;
use core\assets\TrinityWebAssets;
use yii\bootstrap\BootstrapPluginAsset;
use yii\web\AssetBundle;
use yii\web\YiiAsset;

class BackendAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $css = [
        'css/app.css',
    ];
    public $js = [
        'js/app.js',
    ];

    public $depends = [
        BootstrapPluginAsset::class,
        YiiAsset::class,
        Html5shiv::class,
        GlyphIcons::class,
        StellarAsset::class,
        TrinityWebAssets::class,
    ];
}
