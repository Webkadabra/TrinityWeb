<?php

namespace backend\modules\rbac;

use yii\web\AssetBundle;

/**
 * Description of AnimateAsset
 */
class AnimateAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@backend/modules/rbac/assets';
    /**
     * @inheritdoc
     */
    public $css = [
        'animate.css',
    ];

}
