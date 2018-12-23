<?php

namespace frontend\modules\ladder\assets;

use frontend\assets\DefaultAsset;
use Yii;
use yii\web\AssetBundle;

/**
 * LadderAsset module assets
 */
class LadderAssets extends AssetBundle
{
    /**
     * @var array
     */
    public $css = [
        'css/ladder.css',
    ];

    /**
     * @var array
     */
    public $js = [
        'js/ladder.js',
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
        $this->sourcePath = rtrim(Yii::getAlias("@app/themes/$theme/modules/ladder/assets/"), '/\\');

        if ($this->basePath !== null) {
            $this->basePath = rtrim(Yii::getAlias($this->basePath), '/\\');
        }
        if ($this->baseUrl !== null) {
            $this->baseUrl = rtrim(Yii::getAlias($this->baseUrl), '/');
        }
    }
}