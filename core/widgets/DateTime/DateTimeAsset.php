<?php
namespace core\widgets\DateTime;

use yii\web\AssetBundle;

class DateTimeAsset extends AssetBundle
{
    /**
     * @var string
     */
    public $sourcePath = '@vendor/eonasdan/bootstrap-datetimepicker';

    /**
     * @var array
     */
    public $css = [
        'build/css/bootstrap-datetimepicker.min.css'
    ];

    /**
     * @var array
     */
    public $js = [
        'build/js/bootstrap-datetimepicker.min.js',
    ];

    /**
     * @var array
     */
    public $depends = [
        'yii\web\JqueryAsset',
        'yii\bootstrap\BootstrapAsset',
        MomentAsset::class
    ];

}