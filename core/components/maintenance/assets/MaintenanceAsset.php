<?php

namespace core\components\maintenance\assets;

use yii\web\AssetBundle;

/**
 * Class MaintenanceAsset
 * @package core\components\maintenance
 */
class MaintenanceAsset extends AssetBundle
{
    public $sourcePath = '@core/components/maintenance/assets/static';

    public $css = [
        'css/maintenance.css'
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset'
    ];
}