<?php

namespace core\modules\forum\widgets\gridview;

use core\modules\forum\helpers\Helper;
use yii\grid\DataColumn as YiiDataColumn;

/**
 * Podium DataColumn
 */
class DataColumn extends YiiDataColumn
{
    /**
     * @var boolean whether the header label should be HTML-encoded.
     */
    public $encodeLabel = false;

    /**
     * @inheritdoc
     */
    protected function getHeaderCellLabel()
    {
        if (!empty($this->attribute)) {
            return parent::getHeaderCellLabel() . Helper::sortOrder($this->attribute);
        }

        return parent::getHeaderCellLabel();
    }
}
