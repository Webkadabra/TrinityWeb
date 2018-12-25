<?php

namespace frontend\modules\armory\assets;

use frontend\assets\DefaultAsset;
use Yii;
use yii\web\AssetBundle;

/**
 * ArmoryAsset module assets
 */
class ArmoryAsset extends AssetBundle
{
    /**
     * @var array
     */
    public $css = [
        'css/armory.css',
    ];

    /**
     * @var array
     */
    public $js = [
        'js/armory.js',
    ];

    /**
     * @var array
     */
    public $depends = [
        DefaultAsset::class,
    ];

    /**
     * Initializes the bundle.
     * If you override this method, make sure you call the parent implementation in the last.
     */
    public function init()
    {
        $theme = Yii::$app->view->theme->getCurrentTheme();
        $this->sourcePath = rtrim(Yii::getAlias("@app/themes/$theme/modules/armory/assets/"), '/\\');

        if ($this->basePath !== null) {
            $this->basePath = rtrim(Yii::getAlias($this->basePath), '/\\');
        }
        if ($this->baseUrl !== null) {
            $this->baseUrl = rtrim(Yii::getAlias($this->baseUrl), '/');
        }
    }
}