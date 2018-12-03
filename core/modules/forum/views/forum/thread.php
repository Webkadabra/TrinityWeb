<?php

/**
 * Podium Module
 * Yii 2 Forum Module
 */

use core\modules\forum\models\User;
use core\modules\forum\Podium;
use core\modules\forum\rbac\Rbac;
use core\modules\forum\widgets\Avatar;
use core\modules\forum\widgets\editor\EditorBasic;
use core\modules\forum\widgets\poll\Poll;
use core\modules\forum\widgets\Readers;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ListView;
use yii\widgets\Pjax;

$this->title = $thread->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('podium/view', 'Main Forum'), 'url' => ['forum/index']];
$this->params['breadcrumbs'][] = ['label' => $thread->forum->category->name, 'url' => ['forum/category', 'id' => $thread->forum->category->id, 'slug' => $thread->forum->category->slug]];
$this->params['breadcrumbs'][] = ['label' => $thread->forum->name, 'url' => ['forum/forum', 'cid' => $thread->forum->category->id, 'id' => $thread->forum->id, 'slug' => $thread->forum->slug]];
$this->params['breadcrumbs'][] = $this->title;

$this->registerJs("$('[data-toggle=\"tooltip\"]').tooltip();");
$this->registerJs("$('.add-subscription').click(function (e) { e.preventDefault(); $.post('" . Url::to(['profile/add', 'id' => $thread->id]) . "', {}, null, 'json').fail(function(){ console.log('Subscription Add Error!'); }).done(function(data){ $('#subsription-status').html(data.msg); }); });");
$this->registerJs("var anchor = window.location.hash; if (anchor.match(/^#post[0-9]+$/)) $(anchor).find('.podium-content').addClass('podium-gradient');");

?>
<?php if (User::can(Rbac::PERM_UPDATE_THREAD, ['item' => $thread])): ?>
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <ul class="list-inline">
                    <li class="list-inline-item"><strong><?= Yii::t('podium/view', 'Moderator options') ?></strong>:</li>
<?php if (User::can(Rbac::PERM_PIN_THREAD, ['item' => $thread])): ?>
                    <li class="list-inline-item">
                        <a href="<?= Url::to(['forum/pin', 'cid' => $thread->category_id, 'fid' => $thread->forum_id, 'id' => $thread->id, 'slug' => $thread->slug]) ?>" class="btn btn-primary btn-xs">
                            <span class="glyphicon glyphicon-pushpin"></span>
                            <?php if ($thread->pinned): ?>
                            <span class="d-none d-sm-none"><?= Yii::t('podium/view', 'Unpin Thread') ?></span>
                            <span class="d-none d-md-none hidden-lg"><?= Yii::t('podium/view', 'Unpin') ?></span>
                            <?php else: ?>
                            <span class="d-none d-sm-none"><?= Yii::t('podium/view', 'Pin Thread') ?></span>
                            <span class="d-none d-md-none hidden-lg"><?= Yii::t('podium/view', 'Pin') ?></span>
                            <?php endif ?>
                        </a>
                    </li>
<?php endif; ?>
<?php if (User::can(Rbac::PERM_LOCK_THREAD, ['item' => $thread])): ?>
                    <li class="list-inline-item">
                        <a href="<?= Url::to(['forum/lock', 'cid' => $thread->category_id, 'fid' => $thread->forum_id, 'id' => $thread->id, 'slug' => $thread->slug]) ?>" class="btn btn-primary btn-xs">
                            <span class="glyphicon glyphicon-lock"></span>
                            <?php if ($thread->locked): ?>
                            <span class="d-none d-sm-none"><?= Yii::t('podium/view', 'Unlock Thread') ?></span>
                            <span class="d-none d-md-none hidden-lg"><?= Yii::t('podium/view', 'Unlock') ?></span>
                            <?php else: ?>
                            <span class="d-none d-sm-none"><?= Yii::t('podium/view', 'Lock Thread') ?></span>
                            <span class="d-none d-md-none hidden-lg"><?= Yii::t('podium/view', 'Lock') ?></span>
                            <?php endif ?>
                        </a>
                    </li>
<?php endif; ?>
<?php if (User::can(Rbac::PERM_MOVE_THREAD, ['item' => $thread])): ?>
                    <li class="list-inline-item">
                        <a href="<?= Url::to(['forum/move', 'cid' => $thread->category_id, 'fid' => $thread->forum_id, 'id' => $thread->id, 'slug' => $thread->slug]) ?>" class="btn btn-warning btn-xs">
                            <span class="glyphicon glyphicon-share-alt"></span>
                            <span class="d-none d-sm-none"><?= Yii::t('podium/view', 'Move Thread') ?></span>
                            <span class="d-none d-md-none hidden-lg"><?= Yii::t('podium/view', 'Move T') ?></span>
                        </a>
                    </li>
<?php endif; ?>
<?php if (User::can(Rbac::PERM_DELETE_THREAD, ['item' => $thread])): ?>
                    <li class="list-inline-item">
                        <a href="<?= Url::to(['forum/delete', 'cid' => $thread->category_id, 'fid' => $thread->forum_id, 'id' => $thread->id, 'slug' => $thread->slug]) ?>" class="btn btn-danger btn-xs">
                            <span class="glyphicon glyphicon-trash"></span>
                            <span class="d-none d-sm-none"><?= Yii::t('podium/view', 'Delete Thread') ?></span>
                            <span class="d-none d-md-none hidden-lg"><?= Yii::t('podium/view', 'Delete T') ?></span>
                        </a>
                    </li>
<?php endif; ?>
<?php if (User::can(Rbac::PERM_MOVE_POST, ['item' => $thread])): ?>
                    <li class="list-inline-item">
                        <a href="<?= Url::to(['forum/moveposts', 'cid' => $thread->category_id, 'fid' => $thread->forum_id, 'id' => $thread->id, 'slug' => $thread->slug]) ?>" class="btn btn-warning btn-xs">
                            <span class="glyphicon glyphicon-random"></span>
                            <span class="d-none d-sm-none"><?= Yii::t('podium/view', 'Move Posts') ?></span>
                            <span class="d-none d-md-none hidden-lg"><?= Yii::t('podium/view', 'Move P') ?></span>
                        </a>
                    </li>
<?php endif; ?>
<?php if (User::can(Rbac::PERM_DELETE_POST, ['item' => $thread])): ?>
                    <li class="list-inline-item">
                        <a href="<?= Url::to(['forum/deleteposts', 'cid' => $thread->category_id, 'fid' => $thread->forum_id, 'id' => $thread->id, 'slug' => $thread->slug]) ?>" class="btn btn-danger btn-xs">
                            <span class="glyphicon glyphicon-remove"></span>
                            <span class="d-none d-sm-none"><?= Yii::t('podium/view', 'Delete Posts') ?></span>
                            <span class="d-none d-md-none hidden-lg"><?= Yii::t('podium/view', 'Delete P') ?></span>
                        </a>
                    </li>
<?php endif; ?>
                </ul>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<div class="row mt-3">
    <div class="col-sm-12 text-right">
        <ul class="list-inline">
<?php if (Podium::getInstance()->user->isGuest): ?>
            <li class="list-inline-item"><a href="<?= Url::to(['account/login']) ?>" class="btn btn-primary btn-sm"><?= Yii::t('podium/view', 'Sign in to reply') ?></a></li>
            <li class="list-inline-item"><a href="<?= Url::to(['account/register']) ?>" class="btn btn-success btn-sm"><?= Yii::t('podium/view', 'Register new account') ?></a></li>
<?php else: ?>
<?php if (User::can(Rbac::PERM_CREATE_THREAD)): ?>
            <li class="list-inline-item"><a href="<?= Url::to(['forum/new-thread', 'cid' => $thread->forum->category->id, 'fid' => $thread->forum_id]) ?>" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-plus"></span> <?= Yii::t('podium/view', 'Create new thread') ?></a></li>
<?php endif; ?>
            <li class="list-inline-item"><a href="<?= Url::to(['forum/unread-posts']) ?>" class="btn btn-info btn-sm"><span class="glyphicon glyphicon-flash"></span> <?= Yii::t('podium/view', 'Unread posts') ?></a></li>
<?php endif; ?>
        </ul>
    </div>
</div>

<?php
$headerClass = 'default';
$headerIcon = Html::tag('span', '', ['class' => 'glyphicon glyphicon-comment']);
if ($thread->pinned) {
    $headerClass = 'success';
    $headerIcon = Html::tag('span', '', ['class' => 'glyphicon glyphicon-pushpin']);
}
if ($thread->locked) {
    $headerClass = 'danger';
    $headerIcon = Html::tag('span', '', ['class' => 'glyphicon glyphicon-lock']);
}
?>

<div class="row">
    <div class="col-sm-12">
        <div class="card card-<?= $headerClass ?>">
            <div class="card-header">
                <h3 class="card-title">
<?php if ($thread->subscription): ?>
                    <a href="<?= Url::to(['profile/subscriptions']) ?>" class="btn btn-default btn-lg float-right" data-toggle="tooltip" data-placement="left" title="<?= Yii::t('podium/view', 'You subscribe this thread') ?>"><span class="glyphicon glyphicon-star"></span></a>
<?php elseif (!Podium::getInstance()->user->isGuest): ?>
                    <small id="subsription-status" class="float-right"><button class="add-subscription btn btn-success btn-xs"><span class="glyphicon glyphicon-star-empty"></span> <?= Yii::t('podium/view', 'Subscribe to this thread') ?></button></small>
<?php endif; ?>
                    <?= $headerIcon ?> <?= Html::encode($thread->name) ?>
                </h3>
            </div>
        </div>
    </div>
</div><br>

<?= Poll::widget(['model' => $thread->poll]); ?>

<?php Pjax::begin(); ?>
<?= ListView::widget([
    'dataProvider'     => $dataProvider,
    'itemView'         => '/elements/forum/_post',
    'summary'          => '',
    'emptyText'        => Yii::t('podium/view', 'No posts have been added yet.'),
    'itemOptions' => function($model,$key,$index) {
        return $key > 1 ? ['class' => 'mt-4'] : [];
    },
    'emptyTextOptions' => ['tag' => 'h3', 'class' => 'text-muted'],
    'pager'            => ['options' => ['class' => 'pagination float-right']]
]); ?>
<?php Pjax::end(); ?>

<?php if ($thread->locked == 0 || ($thread->locked == 1 && User::can(Rbac::PERM_UPDATE_THREAD, ['item' => $thread]))): ?>
<?php if (!Podium::getInstance()->user->isGuest): ?>
<br>
<div class="row">
    <div class="col-sm-12 text-right">
        <a href="<?= Url::to(['forum/post', 'cid' => $thread->forum->category->id, 'fid' => $thread->forum->id, 'tid' => $thread->id]) ?>" class="btn btn-primary btn-lg"><span class="glyphicon glyphicon-leaf"></span> <?= Yii::t('podium/view', 'New Reply'); ?></a>
    </div>
</div>
<br>
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-2 text-center">
                <div class="card">
                    <div class="card-body px-0 pt-0 pb-0">
                        <?= Avatar::widget(['author' => User::findMe(), 'showName' => false]) ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-10">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title mb-0">
                            <small class="float-right">
                                <?= Html::tag('span', Yii::t('podium/view', 'In a while'), [
                                        'data-toggle' => 'tooltip',
                                        'data-placement' => 'top',
                                        'title' => Yii::t('podium/view', 'As soon as you click Post Reply')
                                    ]
                                ); ?>
                            </small>
                            <strong>
                                <?= Yii::t('podium/view', 'Post Quick Reply') ?>
                            </strong>
                        </div>
                    </div>
                    <div class="card-body">
                        <?php $form = ActiveForm::begin(['id' => 'new-quick-post-form', 'action' => ['post', 'cid' => $thread->forum->category->id, 'fid' => $thread->forum->id, 'tid' => $thread->id]]); ?>
                        <div class="row">
                            <div class="col-sm-12">
                                <?= $form->field($model, 'content')->label(false)->widget(\core\modules\forum\widgets\editor\EditorFull::class) ?>
                            </div>
                        </div>
                        <?php if (!$thread->subscription): ?>
                            <div class="row">
                                <div class="col-sm-12">
                                    <?php
                                    $field = $form->field($model, 'subscribe', ['options' => [
                                        'class' => 'position-relative'
                                    ]]);
                                    $field->template = '{input} {label}';
                                    echo $field->checkbox([], false)->label(Yii::t('podium/view', 'Subscribe to this thread'),[
                                        'class' => 'checkbox-label'
                                    ])
                                    ?>
                                </div>
                            </div>
                        <?php else: ?>
                            <?= Html::activeHiddenInput($model, 'subscribe') ?>
                        <?php endif; ?>
                        <div class="row">
                            <div class="col-sm-8">
                                <div class="form-group">
                                    <?= Html::submitButton('<span class="glyphicon glyphicon-ok-sign"></span> ' . Yii::t('podium/view', 'Post Quick Reply'), ['class' => 'btn btn-block btn-primary', 'name' => 'save-button']) ?>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <?= Html::submitButton('<span class="glyphicon glyphicon-eye-open"></span> ' . Yii::t('podium/view', 'Preview'), ['class' => 'btn btn-block btn-default', 'name' => 'preview-button']) ?>
                                </div>
                            </div>
                        </div>
                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php else: ?>
<div class="row mt-4">
    <br>
    <div class="col-sm-12 text-right">
        <a href="<?= Url::to(['account/login']) ?>" class="btn btn-primary"><?= Yii::t('podium/view', 'Sign in to reply') ?></a>
        <a href="<?= Url::to(['account/register']) ?>" class="btn btn-success"><?= Yii::t('podium/view', 'Register new account') ?></a>
    </div>
</div>
<?php endif; ?>
<?php else: ?>
<div class="row">
    <div class="col-sm-10 col-sm-offset-2 text-center">
        <div class="card card-danger">
            <div class="card-header">
                <h3 class="panel-title"><span class="glyphicon glyphicon-lock"></span> <?= Yii::t('podium/view', 'This thread is locked.') ?></h3>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>
<br>
<div class="card card-default">
    <div class="card-body small">
        <ul class="list-inline float-right">
            <li class="list-inline-item"><a href="<?= Url::to(['forum/index']) ?>" data-toggle="tooltip" data-placement="top" title="<?= Yii::t('podium/view', 'Go to the main page') ?>"><span class="glyphicon glyphicon-home"></span></a></li>
            <li class="list-inline-item"><a href="#top" data-toggle="tooltip" data-placement="top" title="<?= Yii::t('podium/view', 'Go to the top') ?>"><span class="glyphicon glyphicon-arrow-up"></span></a></li>
        </ul>
        <?= Readers::widget(['what' => 'topic']) ?>
    </div>
</div>
