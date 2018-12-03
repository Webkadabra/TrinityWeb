<?php

namespace core\modules\forum\widgets\editor;

use core\modules\forum\Podium;
use core\modules\forum\widgets\codemirror\CodeMirror;
use core\modules\forum\widgets\quill\QuillBasic;
use yii\widgets\InputWidget;

/**
 * Basic Editor for Podium
 */
class EditorBasic extends InputWidget
{
    /**
     * @var InputWidget
     */
    public $editor;

    /**
     * @inheritdoc
     */
    public function init()
    {
        $config = [
            'model' => $this->model,
            'attribute' => $this->attribute,
            'name' => $this->name,
            'value' => $this->value,
            'options' => $this->options
        ];
        if (Podium::getInstance()->podiumConfig->get('use_wysiwyg') == '0') {
            $this->editor = new CodeMirror($config);
        } else {
            if (empty($this->options)) {
                $config['options'] = ['style' => 'min-height:150px;'];
            }
            $this->editor = new QuillBasic($config);
        }
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        return $this->editor->run();
    }
}
