<?php

namespace core\modules\forum\widgets\codemirror\assets;

use yii\web\AssetBundle;

/**
 * CodeMirror Assets
 */
class CodeMirrorAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $depends = [
        'core\modules\forum\widgets\codemirror\assets\CodeMirrorLibAsset',
        'core\modules\forum\widgets\codemirror\assets\CodeMirrorExtraAsset',
        'core\modules\forum\widgets\codemirror\assets\CodeMirrorModesAsset',
        'core\modules\forum\widgets\codemirror\assets\CodeMirrorButtonsAsset',
        'core\modules\forum\widgets\codemirror\assets\CodeMirrorConfigAsset'
    ];
}
