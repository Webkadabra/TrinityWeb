<?php

namespace core\widgets;

/**
 * Class GridView
 */
class GridView extends \yii\grid\GridView
{
    public $pager = [
        'linkContainerOptions' => [
            'class' => 'page-item'
        ],
        'linkOptions' => [
            'class' => 'page-link'
        ],
        'disabledListItemSubTagOptions' => [
            'class' => 'page-link'
        ],
        'disabledPageCssClass' => 'disabled'
    ];
}