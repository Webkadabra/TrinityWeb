<?php

/**
 * Podium Module
 * Yii 2 Forum Module
 */

use core\modules\forum\Podium;
use yii\helpers\Html;

$this->registerJs("$('[data-toggle=\"tooltip\"]').tooltip();");

?>
<div class="row podium-post" id="post<?php echo $model->id; ?>">
    <div class="col-sm-2" id="postAvatar<?php echo $model->id; ?>">
        <?php echo Html::checkbox('post[]', false, ['value' => $model->id, 'label' => Yii::t('podium/view', 'Select this post')]); ?>
    </div>
    <div class="col-sm-10" id="postContent<?php echo $model->id; ?>">
        <div class="popover right podium">
            <div class="arrow"></div>
            <div class="popover-title">
                <small class="float-right">
                    <span data-toggle="tooltip" data-placement="top" title="<?php echo Podium::getInstance()->formatter->asDatetime($model->created_at, 'long'); ?>"><?php echo Podium::getInstance()->formatter->asRelativeTime($model->created_at); ?></span>
<?php if ($model->edited && $model->edited_at): ?>
                    <em>(<?php echo Yii::t('podium/view', 'Edited'); ?> <span data-toggle="tooltip" data-placement="top" title="<?php echo Podium::getInstance()->formatter->asDatetime($model->edited_at, 'long'); ?>"><?php echo Podium::getInstance()->formatter->asRelativeTime($model->edited_at); ?>)</span></em>
<?php endif; ?>
                </small>
                <?php echo $model->author->podiumTag; ?>
                <small>
                    <span class="label label-info" data-toggle="tooltip" data-placement="top" title="<?php echo Yii::t('podium/view', 'Number of posts'); ?>"><?php echo $model->author->postsCount; ?></span>
                </small>
            </div>
            <div class="popover-content podium-content">
                <?php echo $model->parsedContent; ?>
            </div>
        </div>
    </div>
</div>
