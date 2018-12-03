<?php

namespace core\modules\forum\widgets\quill;

use bizley\quill\Quill;

/**
 * Podium Quill widget with basic toolbar.
 */
class QuillBasic extends Quill
{
    /**
     * @var bool|string|array Toolbar buttons.
     */
    public $toolbarOptions = [
        ['bold', 'italic', 'underline', 'strike'],
        [['list' => 'ordered'], ['list' => 'bullet']],
        [['align' => []]],
        ['link']
    ];
}
