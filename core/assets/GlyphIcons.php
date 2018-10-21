<?php

namespace core\assets;

use yii\web\AssetBundle;

class GlyphIcons extends AssetBundle
{
    public $sourcePath = '@core/assets/resources';
    public $css = [
        'css/glyphicons.css'
    ];
    public $depends = [];
}
