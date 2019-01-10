<?php

namespace core\modules\forum\widgets;

use Yii;
use yii\base\Widget;

/**
 * Podium Friends widget
 * Renders user avatar image for each post.
 */
class Friends extends Widget
{
    protected $count;

    /**
     * @return string
     */
    public function run()
    {
        if(Yii::$app->settings->get(Yii::$app->settings::APP_MODULE_FORUM_STATUS) == Yii::$app->settings::ENABLED) {
            $friends = [];
            return $this->render('Friends/friends-list', ['friends' => $friends]);
        } else {
            return null;
        }
    }
}
