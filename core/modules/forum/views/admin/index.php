<?php

/**
 * Podium Module
 * Yii 2 Forum Module
 */

use core\modules\forum\Podium;
use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\helpers\Url;

$this->title = Yii::t('podium/view', 'Administration Dashboard');
$this->params['breadcrumbs'][] = $this->title;

$this->registerJs("$('[data-toggle=\"tooltip\"]').tooltip();");
$this->registerJs("$('[data-toggle=\"popover\"]').popover();");

?>
<?php echo $this->render('/elements/admin/_navbar', ['active' => 'index']); ?>
<br>
<div class="row">
    <div class="col-sm-3">
        <div class="card panel-success">
            <div class="card-header"><?php echo Yii::t('podium/view', 'Newest members'); ?></div>
            <table class="table">
<?php foreach ($members as $member): ?>
                <tr>
                    <td>
                        <a href="<?php echo Url::to(['admin/view', 'id' => $member->id]); ?>"><?php echo $member->podiumName; ?></a>
                        <span data-toggle="tooltip" data-placement="top" title="<?php echo Podium::getInstance()->formatter->asDateTime($member->created_at, 'long'); ?>">
                            <?php echo Podium::getInstance()->formatter->asRelativeTime($member->created_at); ?>
                        </span>
                    </td>
                </tr>
<?php endforeach; ?>
            </table>
        </div>
    </div>
    <div class="col-sm-9">
        <div class="card panel-info table-responsive">
            <div class="card-header"><?php echo Yii::t('podium/view', 'Newest posts'); ?></div>
            <table class="table">
                <thead>
                    <tr>
                        <th><?php echo Yii::t('podium/view', 'Thread'); ?></th>
                        <th><?php echo Yii::t('podium/view', 'Preview'); ?></th>
                        <th><?php echo Yii::t('podium/view', 'Author'); ?></th>
                        <th><?php echo Yii::t('podium/view', 'Date'); ?></th>
                        <th><?php echo Yii::t('podium/view', 'Thumbs'); ?></th>
                    </tr>
                </thead>
                <tbody>
<?php foreach ($posts as $post): ?>
                    <tr>
                        <td>
                            <a href="<?php echo Url::to(['forum/show', 'id' => $post->id]); ?>"><?php echo Html::encode($post->thread->name); ?></a>
                        </td>
                        <td>
                            <span data-toggle="popover" data-container="body" data-placement="right" data-trigger="hover focus" data-html="true" data-content="<small><?php echo str_replace('"', '&quote;', StringHelper::truncateWords($post->parsedContent, 20, '...', true)); ?></small>" title="<?php echo Yii::t('podium/view', 'Post Preview'); ?>">
                                <span class="glyphicon glyphicon-leaf"></span>
                            </span>
                        </td>
                        <td>
                            <a href="<?php echo Url::to(['admin/view', 'id' => $post->author->id]); ?>"><?php echo $post->author->podiumName; ?></a>
                        </td>
                        <td>
                            <span data-toggle="tooltip" data-placement="top" title="<?php echo Podium::getInstance()->formatter->asDateTime($post->created_at, 'long'); ?>">
                                <?php echo Podium::getInstance()->formatter->asRelativeTime($post->created_at); ?>
                            </span>
                        </td>
                        <td>
                            +<?php echo $post->likes; ?> / -<?php echo $post->dislikes; ?>
                        </td>
                    </tr>
<?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
