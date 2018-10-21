<?php

namespace backend\assets;

use yii\bootstrap4\BootstrapPluginAsset;
use yii\web\AssetBundle;
use yii\web\YiiAsset;

use core\assets\Html5shiv;
use core\assets\GlyphIcons;
use core\assets\TrinityWebAssets;

class BackendAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $css = [
        'css/app.css',
    ];
    public $js = [
        'js/app.js'
    ];

    public $depends = [
        BootstrapPluginAsset::class,
        YiiAsset::class,
        Html5shiv::class,
        GlyphIcons::class,
        StellarAsset::class,
        TrinityWebAssets::class
    ];
}
