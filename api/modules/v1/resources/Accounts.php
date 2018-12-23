<?php

namespace api\modules\v1\resources;

use yii\helpers\Url;
use yii\web\Link;
use yii\web\Linkable;

/**
 * @property array  $links
 * @property string $url
 */
class Accounts extends \core\models\auth\Accounts implements Linkable
{
    public function fields()
    {
        return [
            'id',
            'username',
            'email',
            'joindate',
            'online',
            'expansion',
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
            Link::REL_SELF => Url::to(['accounts/view', 'id' => $this->id], true),
        ];
    }
}
