<?php declare(strict_types=1);

namespace core\models\query;

use omgdef\multilingual\MultilingualQuery;

use core\models\Page;

/**
 * Class PageQuery
 * @package core\models\query
 */
class PageQuery extends MultilingualQuery
{
    /**
     * @return $this
     */
    public function published()
    {
        $this->andWhere(['status' => Page::STATUS_PUBLISHED]);
        return $this;
    }
}