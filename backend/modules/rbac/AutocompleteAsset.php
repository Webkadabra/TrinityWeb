<?php

namespace backend\modules\rbac;

use yii\web\AssetBundle;

/**
 * AutocompleteAsset
 */
class AutocompleteAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@backend\modules\rbac/admin/assets';
    /**
     * @inheritdoc
     */
    public $css = [
        'jquery-ui.css',
    ];
    /**
     * @inheritdoc
     */
    public $js = [
        'jquery-ui.js',
    ];
    /**
     * @inheritdoc
     */
    public $depends = [
        'yii\web\JqueryAsset',
    ];

}
