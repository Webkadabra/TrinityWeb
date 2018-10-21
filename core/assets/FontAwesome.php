<?php

namespace core\assets;

use yii\web\AssetBundle;

class FontAwesome extends AssetBundle
{
    public $sourcePath = '@bower/font-awesome/web-fonts-with-css';
    public $css = [
        'css/fontawesome-all.css'
    ];
}
