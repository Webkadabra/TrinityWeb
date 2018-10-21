<?php

namespace core\assets;

use yii\web\AssetBundle;

class Html5shiv extends AssetBundle
{
    public $sourcePath = '@bower/html5shiv/src';
    public $js = [
        'html5shiv.js'
    ];

    public $jsOptions = [
        'condition' => 'lt IE 9'
    ];
}
