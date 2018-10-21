<?php

namespace core\assets;

use yii\web\AssetBundle;
use yii\bootstrap\BootstrapAsset;

class TrinityWebAssets extends AssetBundle
{
    public $sourcePath = '@core/assets/resources';
    public $css = [
        'css/font-play.css',
        'css/trinity-web.css'
    ];
    public $depends = [
        BootstrapAsset::class,
        Html5shiv::class,
        GlyphIcons::class,
        FontAwesome::class,
        RpgAwesome::class
    ];
}
