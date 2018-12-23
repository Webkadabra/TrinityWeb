<?php

/**
 * Podium Module
 * Yii 2 Forum Module
 */

use core\modules\forum\Podium;
use core\modules\forum\widgets\Avatar;
use yii\helpers\Html;

?>
<div class="row">
    <div class="col-sm-2 text-center">
        <?php echo Avatar::widget(['author' => $reply->reply->sender]); ?>
    </div>
    <div class="col-sm-10">
        <div class="popover right podium">
            <div class="arrow"></div>
            <div class="popover-title">
                <small class="float-right"><span data-toggle="tooltip" data-placement="top" title="<?php echo Podium::getInstance()->formatter->asDatetime($reply->reply->created_at, 'long'); ?>"><?php echo Podium::getInstance()->formatter->asRelativeTime($reply->reply->created_at); ?></span></small>
                <?php echo Html::encode($reply->reply->topic); ?>
            </div>
            <div class="popover-content">
                <?php echo $reply->reply->parsedContent; ?>
            </div>
        </div>
    </div>
</div>