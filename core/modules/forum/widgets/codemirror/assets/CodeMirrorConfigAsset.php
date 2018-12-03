<?php

namespace core\modules\forum\widgets\codemirror\assets;

use yii\web\AssetBundle;

/**
 * CodeMirror config Assets
 */
class CodeMirrorConfigAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@forum/widgets/codemirror/podium';

    /**
     * @inheritdoc
     */
    public $js = ['podium-codemirror.js'];

    /**
     * @inheritdoc
     */
    public $css = ['podium-codemirror.css'];
}
