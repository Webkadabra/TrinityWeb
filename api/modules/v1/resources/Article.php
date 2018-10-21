<?php

namespace api\modules\v1\resources;

use Yii;
use yii\helpers\Url;
use yii\web\Link;
use yii\web\Linkable;

/**
 *
 * @property array $links
 * @property string $url
 */
class Article extends \core\models\Article implements Linkable
{
    public function fields()
    {
        return [
            'id',
            'slug',
            'category',
            'title',
            'body',
            'published_at',
            'thumbnail_base_url',
            'thumbnail_path',
            'author',
            'articleAttachments',
            'url'
        ];
    }

    /**
     * Returns a list of links.
     *
     * @return array the links
     */
    public function getLinks()
    {
        return [
            Link::REL_SELF => Url::to(['article/view', 'id' => $this->id], true)
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
    {
        return parent::getAuthor()->select(['id','username','email','created_at']);
    }

    /**
     * Return link to page with article
     * @return string
     */
    public function getUrl()
    {
        return Yii::$app->urlManagerFrontend->createAbsoluteUrl(['article/view','slug' => $this->slug],true);
    }

}
