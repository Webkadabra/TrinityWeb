<?php

namespace core\modules\forum\widgets\codemirror\assets;

use yii\web\AssetBundle;

/**
 * CodeMirror Buttons Assets
 */
class CodeMirrorButtonsAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@bower/codemirror-buttons';

    /**
     * @inheritdoc
     */
    public $js = ['buttons.js'];
}
