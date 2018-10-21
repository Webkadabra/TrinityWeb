<?php

namespace core\assets;

use yii\web\AssetBundle;

class Cookies extends AssetBundle
{
    public $sourcePath = '@core/assets/resources';
    public $css = [
        'css/cookieconsent.min.css'
    ];
    public $js = [
        'js/cookieconsent.min.js',
        'js/cookies.js'
    ];
}
