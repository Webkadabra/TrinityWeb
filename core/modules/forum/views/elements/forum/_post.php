<?php

/**
 * Podium Module
 * Yii 2 Forum Module
 */

use core\modules\forum\assets\HighlightAsset;
use core\modules\forum\models\User;
use core\modules\forum\Podium;
use core\modules\forum\rbac\Rbac;
use core\modules\forum\widgets\Avatar;
use yii\helpers\Html;
use yii\helpers\Url;

$this->registerJs("$('[data-toggle=\"tooltip\"]').tooltip();");
$this->registerJs(<<<'JS'
$('.podium-quote').click(function(e) {
    e.preventDefault();
    var selection = '';
    if (window.getSelection) {
        selection = window.getSelection().toString();
    } else if (document.selection && document.selection.type != 'Control') {
        selection = document.selection.createRange().text;
    }
    $(this).parent().find('.quote-selection').val(selection);
    $(this).parent().find('.quick-quote-form').submit();
});
JS
);
$urlThumb = Url::to(['forum/thumb']);
$this->registerJs(<<<JS
function thumbVote(link, type, thumb, removeClass, addClass) {
    var parent = link.closest('.popover.podium');
    link.removeClass(removeClass).addClass('disabled text-muted');
    $.post('$urlThumb', {thumb: type, post: link.data('post-id')}, null, 'json')
        .fail(function() {
            console.log('Thumb ' + type + ' error!');
        })
        .done(function(data) {
            parent.find('.podium-thumb-info').html(data.msg);
            if (data.error == 0) {
                var cl = 'default';
                if (data.summ > 0) {
                    cl = 'success';
                } else if (data.summ < 0) {
                    cl = 'danger';
                }
                parent.find('.podium-rating').removeClass('label-default label-danger label-success').addClass('label-' + cl).text(data.summ);
                parent.find('.podium-rating-details').text(data.likes + ' / ' + data.dislikes);
            }
            parent.find(thumb).removeClass('disabled text-muted').addClass(addClass);
        });
}
JS
);
$this->registerJs("$('.podium-thumb-up').click(function(e) { e.preventDefault(); thumbVote($(this), 'up', '.podium-thumb-down', 'btn-success', 'btn-danger'); });");
$this->registerJs("$('.podium-thumb-down').click(function(e) { e.preventDefault(); thumbVote($(this), 'down', '.podium-thumb-up', 'btn-danger', 'btn-success'); });");
$this->registerJs("$('.podium-rating').click(function (e) { e.preventDefault(); $('.podium-rating-details').removeClass('hidden'); });");
$this->registerJs("$('.podium-rating-details').click(function (e) { e.preventDefault(); $('.podium-rating-details').addClass('hidden'); });");

if (!Podium::getInstance()->user->isGuest) {
    $model->markSeen();
}

$rating = $model->likes - $model->dislikes;
$ratingClass = 'default';
if ($rating > 0) {
    $ratingClass = 'success';
    $rating = '+' . $rating;
}
elseif ($rating < 0) {
    $ratingClass = 'danger';
}

$loggedId = User::loggedId();

if (strpos($model->content, '<pre class="ql-syntax">') !== false) {
    HighlightAsset::register($this);
}
?>
<div class="card">
    <div class="card-body">
        <div class="row podium-post" id="post<?php echo $model->id; ?>">
            <div class="col-sm-2 text-center" id="postAvatar<?php echo $model->id; ?>">
                <div class="card position-sticky sticky-header">
                    <div class="card-body px-0 pt-0 pb-0">
                        <?php echo Avatar::widget(['author' => $model->author, 'showName' => false]); ?>

                    </div>
                    <div class="card-footer">
                        <?php echo Html::tag('p', $model->author->podiumTag, ['class' => 'avatar-name']);?>
                    </div>
                </div>
            </div>
            <div class="col-sm-10" id="postContent<?php echo $model->id; ?>">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title mb-0">
                            <small class="float-right">
                                <span data-toggle="tooltip" data-placement="top" title="<?php echo Podium::getInstance()->formatter->asDatetime($model->created_at, 'long'); ?>">
                                    <?php echo Podium::getInstance()->formatter->asRelativeTime($model->created_at); ?>
                                </span>
                                <?php if ($model->edited && $model->edited_at): ?>
                                    <em>
                                        (<?php echo Yii::t('podium/view', 'Edited'); ?>
                                        <span data-toggle="tooltip" data-placement="top" title="<?php echo Podium::getInstance()->formatter->asDatetime($model->edited_at, 'long'); ?>">
                                            <?php echo Podium::getInstance()->formatter->asRelativeTime($model->edited_at); ?>)
                                        </span>
                                    </em>
                                <?php endif; ?>
                                &mdash;
                                <span class="podium-rating label label-<?php echo $ratingClass; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo Yii::t('podium/view', 'Rating'); ?>">
                                    <?php echo $rating; ?>
                                </span>
                                <span class="podium-rating-details hidden label label-default">+<?php echo $model->likes; ?> / -<?php echo $model->dislikes; ?></span>
                            </small>
                        </div>
                    </div>
                    <div class="card-body podium">
                        <div class="podium-content">
                            <?php if (isset($parent) && $parent): ?>
                                <a href="<?php echo Url::to(['forum/thread',
                                    'cid'  => $model->thread->category_id,
                                    'fid'  => $model->forum_id,
                                    'id'   => $model->thread_id,
                                    'slug' => $model->thread->slug
                                ]); ?>"><span class="glyphicon glyphicon-comment"></span> <?php echo Html::encode($model->thread->name); ?></a><br><br>
                            <?php endif; ?>
                            <?php echo $model->parsedContent; ?>
                            <?php if (!empty($model->author->userProfile->signature)): ?>
                                <div class="podium-footer small text-muted">
                                    <hr><?php echo $model->author->userProfile->parsedSignature; ?>
                                </div>
                            <?php endif; ?>
                            <ul class="podium-action-bar list-inline">
                                <li class="list-inline-item"><span class="podium-thumb-info"></span></li>
                                <?php if (!Podium::getInstance()->user->isGuest && $model->author_id !== $loggedId): ?>
                                    <li class="list-inline-item"><?php echo Html::beginForm(['forum/post',
                                            'cid' => $model->thread->category_id,
                                            'fid' => $model->forum_id,
                                            'tid' => $model->thread_id,
                                            'pid' => $model->id
                                        ], 'post', ['class' => 'quick-quote-form']); ?>
                                        <?php echo Html::hiddenInput('quote', '', ['class' => 'quote-selection']); ?>
                                        <?php echo Html::endForm(); ?><button
                                                class="btn btn-primary btn-xs podium-quote"
                                                data-toggle="tooltip"
                                                data-placement="top"
                                                title="<?php echo Yii::t('podium/view', 'Reply with quote'); ?>">
                                            <span class="glyphicon glyphicon-leaf"></span>
                                        </button></li>
                                <?php endif; ?>
                                <?php if ($model->author_id === $loggedId || User::can(Rbac::PERM_UPDATE_POST, ['item' => $model->thread])): ?>
                                    <li class="list-inline-item"><a
                                                href="<?php echo Url::to(['forum/edit', 'cid' => $model->thread->category_id, 'fid' => $model->forum_id, 'tid' => $model->thread_id, 'pid' => $model->id]); ?>"
                                                class="btn btn-info btn-xs"
                                                data-pjax="0"
                                                data-toggle="tooltip"
                                                data-placement="top"
                                                title="<?php echo Yii::t('podium/view', 'Edit Post'); ?>">
                                            <span class="glyphicon glyphicon-edit"></span>
                                        </a></li>
                                <?php endif; ?>
                                <li class="list-inline-item"><a
                                            href="<?php echo Url::to(['forum/show', 'id' => $model->id]); ?>"
                                            class="btn btn-default btn-xs"
                                            data-pjax="0"
                                            data-toggle="tooltip"
                                            data-placement="top"
                                            title="<?php echo Yii::t('podium/view', 'Direct link to this post'); ?>">
                                        <span class="glyphicon glyphicon-link"></span>
                                    </a></li>
                                <?php if (!Podium::getInstance()->user->isGuest && $model->author_id !== $loggedId): ?>
                                    <?php if ($model->thumb && $model->thumb->thumb === 1): ?>
                                        <li class="list-inline-item"><a
                                                    href="#"
                                                    class="btn btn-xs disabled text-muted podium-thumb-up"
                                                    data-post-id="<?php echo $model->id; ?>"
                                                    data-toggle="tooltip"
                                                    data-placement="top"
                                                    title="<?php echo Yii::t('podium/view', 'Thumb up'); ?>">
                                                <span class="glyphicon glyphicon-thumbs-up"></span>
                                            </a></li>
                                    <?php else: ?>
                                        <li class="list-inline-item"><a
                                                    href="#"
                                                    class="btn btn-success btn-xs podium-thumb-up"
                                                    data-post-id="<?php echo $model->id; ?>"
                                                    data-toggle="tooltip"
                                                    data-placement="top"
                                                    title="<?php echo Yii::t('podium/view', 'Thumb up'); ?>">
                                                <span class="glyphicon glyphicon-thumbs-up"></span>
                                            </a></li>
                                    <?php endif; ?>
                                    <?php if ($model->thumb && $model->thumb->thumb === -1): ?>
                                        <li class="list-inline-item"><a
                                                    href="#"
                                                    class="btn btn-xs disabled text-muted podium-thumb-down"
                                                    data-post-id="<?php echo $model->id; ?>"
                                                    data-toggle="tooltip"
                                                    data-placement="top"
                                                    title="<?php echo Yii::t('podium/view', 'Thumb down'); ?>">
                                                <span class="glyphicon glyphicon-thumbs-down"></span>
                                            </a></li>
                                    <?php else: ?>
                                        <li class="list-inline-item"><a
                                                    href="#"
                                                    class="btn btn-danger btn-xs podium-thumb-down"
                                                    data-post-id="<?php echo $model->id; ?>"
                                                    data-toggle="tooltip"
                                                    data-placement="top"
                                                    title="<?php echo Yii::t('podium/view', 'Thumb down'); ?>">
                                                <span class="glyphicon glyphicon-thumbs-down"></span>
                                            </a></li>
                                    <?php endif; ?>
                                    <li class="list-inline-item"><a
                                                href="<?php echo Url::to(['forum/report', 'cid' => $model->thread->category_id, 'fid' => $model->forum_id, 'tid' => $model->thread_id, 'pid' => $model->id]); ?>"
                                                class="btn btn-warning btn-xs"
                                                data-pjax="0"
                                                data-toggle="tooltip"
                                                data-placement="top"
                                                title="<?php echo Yii::t('podium/view', 'Report post'); ?>">
                                            <span class="glyphicon glyphicon-flag"></span>
                                        </a></li>
                                <?php endif; ?>
                                <?php if ($model->author_id === $loggedId || User::can(Rbac::PERM_DELETE_POST, ['item' => $model->thread])): ?>
                                    <li class="list-inline-item"><a
                                                href="<?php echo Url::to(['forum/deletepost', 'cid' => $model->thread->category_id, 'fid' => $model->forum_id, 'tid' => $model->thread_id, 'pid' => $model->id]); ?>"
                                                class="btn btn-danger btn-xs"
                                                data-pjax="0"
                                                data-toggle="tooltip"
                                                data-placement="top"
                                                title="<?php echo Yii::t('podium/view', 'Delete Post'); ?>">
                                            <span class="glyphicon glyphicon-trash"></span>
                                        </a></li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
