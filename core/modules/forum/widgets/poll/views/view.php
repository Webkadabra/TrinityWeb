<?php

use core\modules\forum\models\Poll;
use core\modules\forum\models\User;
use core\modules\forum\Podium;
use core\modules\forum\rbac\Rbac;
use yii\helpers\Html;
use yii\helpers\Url;

if (!$voted) {
    $this->registerJs('$(".podium-poll-vote").click(function(e){e.preventDefault();var button=$(this);button.removeClass("btn-primary").addClass("disabled text-muted");$.post("' . Url::to(['forum/poll']) . '",$(".podium-poll-form").serialize(),null,"json").always(function(){button.addClass("btn-primary").removeClass("disabled text-muted");}).fail(function(){console.log("Poll Vote Error!");}).done(function(data){$(".podium-poll-info").html(data.msg);if(data.error==0){for(var a in data.votes){if($(".podium-poll-answer-"+a).length){var perc=parseInt(data.count)>0?Math.ceil(parseInt(data.votes[a])*100/parseInt(data.count)):0;$(".podium-poll-answer-"+a).attr("aria-valuenow",perc);$(".podium-poll-answer-"+a).css("width",perc+"%");$(".podium-poll-answer-"+a).html(perc+"%");$(".podium-poll-answer-votes-"+a).html(parseInt(data.votes[a]));}}$(".podium-poll-form").addClass("d-none");$(".podium-poll-show-form").addClass("d-none");$(".podium-poll-results").removeClass("d-none");}});});');
    if (!$hidden) {
        $this->registerJs('$(".podium-poll-show-results").click(function(e){e.preventDefault();$(".podium-poll-form").addClass("d-none");$(".podium-poll-results").removeClass("d-none");});');
        $this->registerJs('$(".podium-poll-show-form").click(function(e){e.preventDefault();$(".podium-poll-form").removeClass("d-none");$(".podium-poll-results").addClass("d-none");});');
    }
}

$loggedId = User::loggedId();

/* @var $model Poll */
?>
<div class="card podium-poll" id="poll<?php echo $model->id; ?>">
    <div class="card-header">
        <div class="card-title">
            <div class="popover-title">
                <?php if (!empty($model->end_at)): ?>
                    <small class="float-right">
                    <span data-toggle="tooltip" data-placement="top" title="<?php echo Podium::getInstance()->formatter->asDatetime($model->end_at, 'long'); ?>">
                        <?php echo Yii::t('podium/view', 'Poll ends'); ?>: <?php echo Podium::getInstance()->formatter->asRelativeTime($model->end_at); ?>
                    </span>
                    </small>
                <?php endif; ?>
                <?php echo Yii::t('podium/view', 'Poll'); ?>: <strong><?php echo Html::encode($model->question); ?></strong>
            </div>
        </div>
    </div>
    <div class="card-body popover-content">
        <?php if (!$voted): ?>
            <?php echo Html::beginForm('#', 'post', ['class' => 'podium-poll-form']); ?>
            <?php echo Html::hiddenInput('poll_id', $model->id); ?>
            <p class="small"><?php echo Yii::t('podium/view', 'Select {n, plural, =1{only # answer} other{max # answers}}', ['n' => $model->votes]); ?>:</p>
            <?php foreach ($model->answers as $answer): ?>
                <p>
                    <label>
                        <?php if ($model->votes > 1): ?>
                            <?php echo Html::checkbox('poll_vote[]', false, ['class' => 'podium-poll-answer', 'value' => $answer->id]); ?>
                        <?php else: ?>
                            <?php echo Html::radio('poll_vote[]', false, ['class' => 'podium-poll-answer', 'value' => $answer->id]); ?>
                        <?php endif; ?>
                        <?php echo Html::encode($answer->answer); ?>
                    </label>
                </p>
            <?php endforeach; ?>
            <ul class="list-inline">
                <li class="list-inline-item"><button class="btn btn-primary podium-poll-vote"><span class="glyphicon glyphicon-ok-sign"></span> <?php echo Yii::t('podium/view', 'Vote'); ?></button></li>
                <?php if (!$hidden): ?>
                    <li class="list-inline-item"><button class="btn btn-default podium-poll-show-results"><?php echo Yii::t('podium/view', 'See results'); ?></button></li>
                <?php endif; ?>
                <li class="podium-pol l-info list-inline-item"></li>
            </ul>
            <?php echo Html::endForm(); ?>

            <?php if ($display === false && ($model->author_id === $loggedId || User::can(Rbac::PERM_UPDATE_POST, ['item' => $model->thread]))): ?>
                <ul class="podium-action-bar list-inline">
                    <li class="list-inline-item">
                        <a href="<?php echo Url::to(['forum/editpoll', 'cid' => $model->thread->category_id, 'fid' => $model->thread->forum_id, 'tid' => $model->thread_id, 'pid' => $model->id]); ?>" class="btn btn-info btn-xs <?php echo $model->votesCount ? 'disabled text-muted' : ''; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo Yii::t('podium/view', 'Edit Poll'); ?>">
                            <span class="glyphicon glyphicon-edit"></span>
                        </a>
                    </li>
                    <li class="list-inline-item">
                        <a href="<?php echo Url::to(['forum/deletepoll', 'cid' => $model->thread->category_id, 'fid' => $model->thread->forum_id, 'tid' => $model->thread_id, 'pid' => $model->id]); ?>" class="btn btn-danger btn-xs" data-toggle="tooltip" data-placement="top" title="<?php echo Yii::t('podium/view', 'Delete Poll'); ?>">
                            <span class="glyphicon glyphicon-trash"></span>
                        </a>
                    </li>
                </ul>
            <?php endif; ?>

        <?php endif; ?>
        <div class="podium-poll-results <?php echo $voted ? '' : 'd-none'; ?>">
            <?php if (!$hidden || $voted): ?>
                <?php foreach ($model->sortedAnswers as $answer): $perc = $model->votesCount > 0 ? ceil($answer->votes * 100 / $model->votesCount) : 0; ?>
                    <div>
                        <?php echo Html::encode($answer->answer); ?>
                        <div class="progress">
                            <div class="progress-bar progress-bar-success podium-poll-answer-<?php echo $answer->id; ?>" role="progressbar" aria-valuenow="<?php echo $perc; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $perc; ?>%">
                                <?php echo $perc; ?>%
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <?php foreach ($model->answers as $answer): ?>
                    <div>
                        <span class="label label-default float-right podium-poll-answer-votes-<?php echo $answer->id; ?>">?</span>
                        <?php echo Html::encode($answer->answer); ?>
                        <div class="progress">
                            <div class="progress-bar progress-bar-success podium-poll-answer-<?php echo $answer->id; ?>" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
                                ?
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
            <?php if (!$hidden && !$voted): ?>
                <button class="btn btn-default podium-poll-show-form"><?php echo Yii::t('podium/view', 'Back to poll'); ?></button>
            <?php endif; ?>

            <?php if ($display === false && ($model->author_id === $loggedId || User::can(Rbac::PERM_UPDATE_POST, ['item' => $model->thread]))): ?>
                <ul class="podium-action-bar list-inline">
                    <li class="list-inline-item">
                        <a href="<?php echo Url::to(['forum/editpoll', 'cid' => $model->thread->category_id, 'fid' => $model->thread->forum_id, 'tid' => $model->thread_id, 'pid' => $model->id]); ?>" class="btn btn-info btn-xs <?php echo $model->votesCount ? 'disabled text-muted' : ''; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo Yii::t('podium/view', 'Edit Poll'); ?>">
                            <span class="glyphicon glyphicon-edit"></span>
                        </a>
                    </li>
                    <li class="list-inline-item">
                        <a href="<?php echo Url::to(['forum/deletepoll', 'cid' => $model->thread->category_id, 'fid' => $model->thread->forum_id, 'tid' => $model->thread_id, 'pid' => $model->id]); ?>" class="btn btn-danger btn-xs" data-toggle="tooltip" data-placement="top" title="<?php echo Yii::t('podium/view', 'Delete Poll'); ?>">
                            <span class="glyphicon glyphicon-trash"></span>
                        </a>
                    </li>
                </ul>
            <?php endif; ?>

        </div>
    </div>
</div>