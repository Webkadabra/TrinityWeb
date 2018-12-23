<?php

/**
 * Podium Module
 * Yii 2 Forum Module
 */

use core\modules\forum\Podium;
use yii\helpers\Html;
use yii\helpers\Url;

$this->registerJs("$('[data-toggle=\"popover\"]').popover();");

$postModel = !empty($model->posts[0]) ? $model->posts[0] : $model->postData;
?>
<td class="podium-thread-line">
    <a href="<?php echo Url::to(['forum/show', 'id' => $postModel->id]); ?>" class="podium-go-to-new float-right" style="margin-right:10px" data-toggle="popover" data-container="body" data-placement="left" data-trigger="hover focus" data-html="true" data-content="<small><?php echo Html::encode(strip_tags($postModel->parsedContent)); ?><br><strong><?php echo $postModel->author->podiumName; ?></strong> <?php echo Podium::getInstance()->formatter->asRelativeTime($postModel->updated_at); ?></small>" title="<?php echo Yii::t('podium/view', 'Found Post'); ?>">
        <span class="glyphicon glyphicon-comment"></span>
    </a>
    <a href="<?php echo Url::to(['forum/show', 'id' => $postModel->id]); ?>" class="float-left btn btn-<?php echo $postModel->thread->getCssClass(); ?>" style="margin-right:10px" data-toggle="tooltip" data-placement="top" title="<?php echo $postModel->thread->getDescription(); ?>">
        <span class="glyphicon glyphicon-<?php echo $postModel->thread->getIcon(); ?>"></span>
    </a>
    <a href="<?php echo Url::to(['forum/show', 'id' => $postModel->id]); ?>" class="center-block">
        <?php echo Html::encode($postModel->thread->name); ?>
    </a>
</td>
<td class="text-center">
    <?php echo $postModel->thread->posts > 0 ? $postModel->thread->posts - 1 : 0; ?>
</td>
<td class="text-center">
    <?php echo $postModel->thread->views; ?>
</td>
<td>
    <small><?php echo $postModel->author->podiumTag; ?><br><?php echo Podium::getInstance()->formatter->asDatetime($postModel->created_at); ?></small>
</td>
