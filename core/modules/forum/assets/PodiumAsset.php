<?php

namespace core\modules\forum\assets;

use yii\web\AssetBundle;

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
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
