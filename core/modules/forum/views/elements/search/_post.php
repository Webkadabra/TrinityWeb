<?php

/**
 * Podium Module
 * Yii 2 Forum Module
 */

use core\modules\forum\Podium;
use core\modules\forum\widgets\Avatar;
use yii\helpers\Html;
use yii\helpers\Url;

$this->registerJs("$('[data-toggle=\"tooltip\"]').tooltip();");

$content = $model->postData->parsedContent;
$thread = Html::encode($model->postData->thread->name);
if ($type === 'topics') {
    foreach ($words as $word) {
        $thread = preg_replace("/$word/", '<mark>' . $word . '</mark>', $thread);
    }
}
else {
    foreach ($words as $word) {
        $content = preg_replace("/$word/", '<mark>' . $word . '</mark>', $content);
    }
}

?>
<div class="row" id="post<?php echo $model->postData->id; ?>">
    <div class="col-sm-2 text-center" id="postAvatar<?php echo $model->postData->id; ?>">
        <?php echo Avatar::widget(['author' => $model->postData->author, 'showName' => false]); ?>
    </div>
    <div class="col-sm-10" id="postContent<?php echo $model->postData->id; ?>">
        <div class="popover right podium">
            <div class="arrow"></div>
            <div class="popover-title">
                <small class="float-right">
                    <span data-toggle="tooltip" data-placement="top" title="<?php echo Podium::getInstance()->formatter->asDatetime($model->postData->created_at, 'long'); ?>"><?php echo Podium::getInstance()->formatter->asRelativeTime($model->postData->created_at); ?></span>
<?php if ($model->postData->edited && $model->postData->edited_at): ?>
                    <em>(<?php echo Yii::t('podium/view', 'Edited'); ?> <span data-toggle="tooltip" data-placement="top" title="<?php echo Podium::getInstance()->formatter->asDatetime($model->postData->edited_at, 'long'); ?>"><?php echo Podium::getInstance()->formatter->asRelativeTime($model->postData->edited_at); ?>)</span></em>
<?php endif; ?>
                </small>
                <?php echo $model->postData->author->podiumTag; ?>
                <small>
                    <span class="label label-info" data-toggle="tooltip" data-placement="top" title="<?php echo Yii::t('podium/view', 'Number of posts'); ?>"><?php echo $model->postData->author->postsCount; ?></span>
                </small>
            </div>
            <div class="popover-content podium-content">
                <a href="<?php echo Url::to(['forum/thread', 'cid' => $model->postData->thread->category_id, 'fid' => $model->postData->forum_id, 'id' => $model->postData->thread_id, 'slug' => $model->postData->thread->slug]); ?>"><span class="glyphicon glyphicon-comment"></span> <?php echo $thread; ?></a><br><br>
                <?php echo $content; ?>
                <div class="podium-action-bar">
                    <a href="<?php echo Url::to(['forum/show', 'id' => $model->postData->id]); ?>" class="btn btn-default btn-xs" data-pjax="0" data-toggle="tooltip" data-placement="top" title="<?php echo Yii::t('podium/view', 'Direct link to this post'); ?>"><span class="glyphicon glyphicon-link"></span></a>
                </div>
            </div>
        </div>
    </div>
</div>
