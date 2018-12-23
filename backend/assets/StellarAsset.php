<?php

namespace backend\assets;

use yii\web\AssetBundle;

class StellarAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $css = [
        'css/stellar.css',
    ];
    public $js = [
        'js/off-canvas.js',
    ];
}
