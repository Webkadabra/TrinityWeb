<?php

namespace frontend\base\assets;

use Yii;
use yii\bootstrap\BootstrapAsset;
use yii\web\AssetBundle;
use yii\web\YiiAsset;

use core\assets\TrinityWebAssets;

/**
 * BaseFrontendAsset application asset
 */
class BaseFrontendAsset extends AssetBundle
{
    /**
     * @var array
     */
    public $depends = [
        YiiAsset::class,
        BootstrapAsset::class,
        TrinityWebAssets::class
    ];

    /**
     * Initializes the bundle.
     * If you override this method, make sure you call the parent implementation in the last.
     */
    public function init()
    {
        $theme = Yii::$app->view->theme->getCurrentTheme();
        $this->sourcePath = rtrim(Yii::getAlias("@app/themes/$theme/assets"), '/\\');

        if ($this->basePath !== null) {
            $this->basePath = rtrim(Yii::getAlias($this->basePath), '/\\');
        }
        if ($this->baseUrl !== null) {
            $this->baseUrl = rtrim(Yii::getAlias($this->baseUrl), '/');
        }
    }

}
