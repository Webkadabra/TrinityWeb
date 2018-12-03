<?php

namespace core\modules\forum\widgets\codemirror\assets;

use yii\web\AssetBundle;

/**
 * CodeMirror Library Assets
 */
class CodeMirrorLibAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@bower/codemirror/lib';

    /**
     * @inheritdoc
     */
    public $css = ['codemirror.css'];

    /**
     * @inheritdoc
     */
    public $js = ['codemirror.js'];
}
