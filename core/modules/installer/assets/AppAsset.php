<?php
namespace core\modules\installer\assets;

use yii\web\AssetBundle;
use yii\web\YiiAsset;

class AppAsset extends AssetBundle
{
    /**
    * @inheritdoc
    */
    public $sourcePath = '@installer/assets/static';

    public $css = [
        'css/install.css'
    ];

    public $js = [
        'js/install.js'
    ];

    public $depends = [
        YiiAsset::class,
    ];

}