<?php

namespace core\modules\forum\widgets;

use cebe\gravatar\Gravatar;
use core\modules\forum\helpers\Helper;
use core\modules\forum\models\User;
use Yii;
use yii\base\Widget;
use yii\helpers\Html;

/**
 * Podium Avatar widget
 * Renders user avatar image for each post.
 */
class Avatar extends Widget
{
    /**
     * @var User|null Avatar owner.
     */
    public $author;

    /**
     * @var bool Whether user name should appear underneath the image.
     */
    public $showName = true;

    /**
     * Renders the image.
     * Based on user settings the avatar can be uploaded image, Gravatar image or default one.
     * @return string
     */
    public function run()
    {
        $avatar = Html::img(Helper::defaultAvatar(), [
            'class' => 'podium-avatar img-responsive center-block',
            'alt'   => Yii::t('podium/view', 'user deleted')
        ]);
        $name = Helper::deletedUserTag(true);
        if ($this->author instanceof User) {
            $avatar = Html::img(Helper::defaultAvatar(), [
                'class' => 'podium-avatar w-100 img-responsive center-block',
                'alt'   => Html::encode($this->author->podiumName)
            ]);
            $name = $this->author->podiumTag;
            $meta = $this->author->userProfile;
            if (!empty($meta)) {
                if (!empty($meta->picture)) {
                    $avatar = Html::img($meta->picture['base_url'] . '/' . $meta->picture['path'], [
                        'class' => 'podium-avatar w-100 img-responsive center-block',
                        'alt'   => Html::encode($this->author->podiumName)
                    ]);
                }
            }
        }

        return $avatar . ($this->showName ? Html::tag('p', $name, ['class' => 'avatar-name']) : '');
    }
}
