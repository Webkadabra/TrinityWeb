<?php

namespace core\modules\forum\widgets\editor;

use core\modules\forum\Podium;
use core\modules\forum\widgets\codemirror\CodeMirror;
use core\modules\forum\widgets\quill\QuillFull;
use yii\widgets\InputWidget;

/**
 * Full Editor for Podium
 */
class EditorFull extends InputWidget
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
            'model'     => $this->model,
            'attribute' => $this->attribute,
            'name'      => $this->name,
            'value'     => $this->value,
            'options'   => $this->options
        ];
        if (Podium::getInstance()->podiumConfig->get('forum.use_wysiwyg') === '0') {
            $config['type'] = 'full';
            $this->editor = new CodeMirror($config);
        } else {
            if (empty($this->options)) {
                $config['options'] = ['style' => 'min-height:320px;'];
            }
            $this->editor = new QuillFull($config);
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
