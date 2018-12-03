<?php

namespace core\modules\forum\widgets\codemirror\assets;

use yii\web\AssetBundle;

/**
 * CodeMirror Modes Assets
 */
class CodeMirrorModesAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@bower/codemirror/mode';

    /**
     * @inheritdoc
     */
    public $js = [
        'xml/xml.js',
        'javascript/javascript.js',
        'css/css.js',
        'htmlmixed/htmlmixed.js',
        'clike/clike.js',
        'php/php.js',
        'sql/sql.js',
        'meta.js',
        'markdown/markdown.js',
        'gfm/gfm.js',
    ];
}
