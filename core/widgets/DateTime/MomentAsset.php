<?php
namespace core\widgets\DateTime;

use yii\web\AssetBundle;

class MomentAsset extends AssetBundle
{
    /**
     * @var string
     */
    public $sourcePath = '@vendor/moment/moment';

    /**
     * @var array
     */
    public $js = [
        'min/moment-with-locales.min.js',
    ];

    /**
     * @var array
     */
    public $depends = [
        'yii\web\JqueryAsset'
    ];
}