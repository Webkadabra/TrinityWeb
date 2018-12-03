<?php

namespace core\modules\forum\widgets\codemirror\assets;

use yii\web\AssetBundle;

/**
 * CodeMirror Extra Assets
 */
class CodeMirrorExtraAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@bower/codemirror/addon';

    /**
     * @inheritdoc
     */
    public $js = [
        'mode/overlay.js',
        'edit/continuelist.js',
        'fold/xml-fold.js',
        'edit/matchbrackets.js',
        'edit/closebrackets.js',
        'edit/closetag.js',
        'display/panel.js',
    ];
}
