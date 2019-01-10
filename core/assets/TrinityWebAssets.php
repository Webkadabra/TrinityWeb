<?php

namespace core\assets;

use yii\bootstrap\BootstrapAsset;
use yii\web\AssetBundle;

class TrinityWebAssets extends AssetBundle
{
    public $sourcePath = '@core/assets/resources';
    public $css = [
        'css/font-play.css',
        'css/trinity-web.css',
    ];
    public $js = [
        'js/soft-scroll.js',
    ];
    public $depends = [
        BootstrapAsset::class,
        Html5shiv::class,
        GlyphIcons::class,
        FontAwesome::class,
        RpgAwesome::class
    ];
}
