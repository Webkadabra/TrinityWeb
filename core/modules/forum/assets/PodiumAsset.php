<?php

namespace core\modules\forum\assets;

use frontend\assets\DefaultAsset;
use yii\bootstrap\BootstrapAsset;
use yii\web\AssetBundle;
use yii\web\YiiAsset;

/**
 * Podium Assets
 */
class PodiumAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@forum/css';

    /**
     * @inheritdoc
     */
    public $css = ['podium.css'];

    /**
     * @inheritdoc
     */
    public $depends = [
        YiiAsset::class,
        BootstrapAsset::class,
        DefaultAsset::class,
    ];
}
