<?php

/**
 * Podium Module
 * Yii 2 Forum Module
 */

use core\modules\forum\Podium;
use yii\helpers\Html;
use yii\helpers\Url;

$this->registerJs("$('[data-toggle=\"popover\"]').popover();");

$firstToSee = $model->firstToSee();

?>
<td class="podium-thread-line">
    <a href="<?php echo Url::to(['forum/show', 'id' => $firstToSee->id]); ?>" class="podium-go-to-new float-right" style="margin-right:10px" data-toggle="popover" data-container="body" data-placement="left" data-trigger="hover focus" data-html="true" data-content="<small><?php echo Html::encode(strip_tags($firstToSee->parsedContent)); ?><br><strong><?php echo $firstToSee->author->podiumName; ?></strong> <?php echo Podium::getInstance()->formatter->asRelativeTime($firstToSee->updated_at); ?></small>" title="<?php echo Yii::t('podium/view', 'First New Post'); ?>">
        <span class="glyphicon glyphicon-leaf"></span>
    </a>
    <a href="<?php echo Url::to(['forum/thread', 'cid' => $model->category_id, 'fid' => $model->forum_id, 'id' => $model->id, 'slug' => $model->slug]); ?>" class="float-left btn btn-<?php echo $model->getCssClass(); ?>" style="margin-right:10px" data-toggle="tooltip" data-placement="top" title="<?php echo $model->getDescription(); ?>">
        <span class="glyphicon glyphicon-<?php echo $model->getIcon(); ?>"></span>
    </a>
    <a href="<?php echo Url::to(['forum/thread', 'cid' => $model->category_id, 'fid' => $model->forum_id, 'id' => $model->id, 'slug' => $model->slug]); ?>" class="center-block">
        <?php echo Html::encode($model->name); ?>
    </a>
</td>
<td class="text-center"><?php echo $model->posts > 0 ? $model->posts - 1 : 0; ?></td>
<td class="text-center"><?php echo $model->views; ?></td>
<td>
<?php if (!empty($model->latest) && !empty($model->latest->author)): ?>
    <small><?php echo $model->latest->author->podiumTag; ?><br><?php echo Podium::getInstance()->formatter->asDatetime($model->latest->created_at); ?></small>
<?php endif; ?>
</td>
