<?php
namespace frontend\widgets\Marquee;

use Yii;
use yii\base\Widget;

class MarqueeWidget extends Widget
{

    public function run() {
        $text = Yii::$app->settings->get(Yii::$app->settings::APP_ANNOUNCE);
        if($text) {
            return $this->render('index', [
                'text' => $text
            ]);
        }
        return null;
    }
}