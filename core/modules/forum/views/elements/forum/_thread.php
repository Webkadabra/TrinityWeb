<?php

use core\modules\forum\Podium;
use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\helpers\Url;

//$this->registerJs("$('[data-toggle=\"popover\"]').popover();");
$firstToSee = $model->firstToSee();
?>
<td class="podium-thread-line col-6">
    <a href="<?php echo Url::to(['forum/show', 'id' => $firstToSee->id]); ?>" class="podium-go-to-new float-right" style="margin-right:10px" data-pjax="0" data-toggle="popover" data-container="body" data-placement="left" data-trigger="hover focus" data-html="true" data-content="<small><?php echo str_replace('"', '&quote;', StringHelper::truncateWords($firstToSee->parsedContent, 20, '...', true)); ?><br><strong><?php echo $firstToSee->author->podiumName; ?></strong> <?php echo Podium::getInstance()->formatter->asRelativeTime($firstToSee->updated_at); ?></small>" title="<?php echo Yii::t('podium/view', 'First New Post'); ?>">
        <span class="glyphicon glyphicon-leaf"></span>
    </a>
    <a href="<?php echo Url::to(['forum/thread', 'cid' => $model->category_id, 'fid' => $model->forum_id, 'id' => $model->id, 'slug' => $model->slug]); ?>" class="d-none float-left btn btn-<?php echo $model->getCssClass(); ?>" style="margin-right:10px" data-pjax="0" data-toggle="tooltip" data-placement="top" title="<?php echo $model->getDescription(); ?>">
        <span class="glyphicon glyphicon-<?php echo $model->getIcon(); ?>"></span>
    </a>
    <a href="<?php echo Url::to(['forum/thread', 'cid' => $model->category_id, 'fid' => $model->forum_id, 'id' => $model->id, 'slug' => $model->slug]); ?>" class="d-lg-none d-md-none d-sm-none float-left btn btn-<?php echo $model->getCssClass(); ?> btn-xs" style="margin-right:5px" data-pjax="0" data-toggle="tooltip" data-placement="top" title="<?php echo $model->getDescription(); ?>">
        <span class="glyphicon glyphicon-<?php echo $model->getIcon(); ?>"></span>
    </a>
    <a href="<?php echo Url::to(['forum/thread', 'cid' => $model->category_id, 'fid' => $model->forum_id, 'id' => $model->id, 'slug' => $model->slug]); ?>" class="center-block <?php echo $model->locked ? 'text-danger' : ''; ?>" data-pjax="0">
        <?php echo $model->pinned ? '<mark>' : ''; ?><?php echo Html::encode($model->name); ?><?php echo $model->pinned ? '</mark>' : ''; ?>
    </a>
</td>
<td class="text-center col-1">
    <?php echo $model->posts > 0 ? $model->posts - 1 : 0; ?>
</td>
<td class="text-center col-2">
    <?php echo $model->views; ?>
</td>
<td class="col-3">
<?php if (!empty($model->latest) && !empty($model->latest->author)): ?>
    <small>
        <?php echo $model->latest->author->podiumTag; ?>
        <span class="clearfix d-none"><?php echo Podium::getInstance()->formatter->asDatetime($model->latest->created_at, 'medium'); ?></span>
        <span class="clearfix d-sm-none d-md-none hidden-lg"><?php echo Podium::getInstance()->formatter->asDatetime($model->latest->created_at, 'short'); ?></span>
    </small>
<?php endif; ?>
</td>
