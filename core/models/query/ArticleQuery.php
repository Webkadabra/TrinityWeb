<?php

namespace core\models\query;

use core\models\Article;
use omgdef\multilingual\MultilingualQuery;

/**
 * Class ArticleQuery
 * @package core\models\query
 */
class ArticleQuery extends MultilingualQuery
{
    /**
     * @return $this
     */
    public function published()
    {
        $this->andWhere(['status' => Article::STATUS_PUBLISHED]);
        $this->andWhere(['<', '{{%article}}.published_at', time()]);

        return $this;
    }
}