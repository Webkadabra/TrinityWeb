<?php

namespace core\modules\forum\widgets\gridview;

use core\modules\forum\Podium;
use core\modules\forum\widgets\PageSizer;
use yii\grid\GridView as YiiGridView;
use yii\widgets\Pjax;

/**
 * Podium GridView widget.
 */
class GridView extends YiiGridView
{
    /**
     * @var array the HTML attributes for the container tag of the grid view.
     * The "tag" element specifies the tag name of the container element and defaults to "div".
     */
    public $options = ['class' => 'grid-view table-responsive'];
    /**
     * @var string the default data column class if the class name is not explicitly specified when configuring a data column.
     */
    public $dataColumnClass = 'core\modules\forum\widgets\gridview\DataColumn';
    /**
     * @var array the HTML attributes for the grid table element.
     */
    public $tableOptions = ['class' => 'table table-striped table-hover'];
    /**
     * @var string additional jQuery selector for selecting filter input fields
     */
    public $filterSelector = 'select#per-page';

    /**
     * Sets formatter to use Podium component.
     * @since 0.5
     */
    public function init()
    {
        parent::init();
        $this->formatter = Podium::getInstance()->formatter;
    }

    /**
     * Runs the widget.
     */
    public function run()
    {
        Pjax::begin();
        echo PageSizer::widget();
        parent::run();
        Pjax::end();
    }
}
