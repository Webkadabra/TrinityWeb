<?php

use core\modules\forum\helpers\Helper;
use core\modules\forum\models\User;
use core\modules\forum\Podium;
use core\modules\forum\widgets\Modal;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = Yii::t('podium/view', 'Member View');
$this->params['breadcrumbs'][] = ['label' => Yii::t('podium/view', 'Members List'), 'url' => ['members/index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['user'] = $user;

$this->registerJs("$('[data-toggle=\"tooltip\"]').tooltip();");
if (!Podium::getInstance()->user->isGuest) {
    $this->registerJs("$('#podiumModalIgnore').on('show.bs.modal', function(e) { var button = $(e.relatedTarget); $('#ignoreUrl').attr('href', button.data('url')); });");
    $this->registerJs("$('#podiumModalUnIgnore').on('show.bs.modal', function(e) { var button = $(e.relatedTarget); $('#unignoreUrl').attr('href', button.data('url')); });");
}

$loggedId = User::loggedId();
$ignored = $friend = false;
if (!Podium::getInstance()->user->isGuest) {
    $ignored = $user->isIgnoredBy($loggedId);
    $friend = $user->isBefriendedBy($loggedId);
}

?>
<div class="row">
    <div class="col-sm-9">
<?php if (!Podium::getInstance()->user->isGuest): ?>
                <div class="float-right">
<?php if ($user->id !== $loggedId): ?>
                    <a href="<?php echo Url::to(['messages/new', 'user' => $user->id]); ?>" class="btn btn-default btn-lg" data-toggle="tooltip" data-placement="top" title="<?php echo Yii::t('podium/view', 'Send Message'); ?>"><span class="glyphicon glyphicon-envelope"></span></a>
<?php else: ?>
                    <a href="#" class="btn btn-lg disabled text-muted"><span class="glyphicon glyphicon-envelope"></span></a>
<?php endif; ?>
<?php if ($user->id !== $loggedId && $user->role !== User::ROLE_ADMINISTRATOR): ?>
<?php if (!$friend): ?>
                    <a href="<?php echo Url::to(['members/friend', 'id' => $user->id]); ?>" class="btn btn-success btn-lg" data-toggle="tooltip" data-placement="top" title="<?php echo Yii::t('podium/view', 'Add as a Friend'); ?>"><span class="glyphicon glyphicon-plus-sign"></span></a>
<?php else: ?>
                    <a href="<?php echo Url::to(['members/friend', 'id' => $user->id]); ?>" class="btn btn-warning btn-lg" data-toggle="tooltip" data-placement="top" title="<?php echo Yii::t('podium/view', 'Remove Friend'); ?>"><span class="glyphicon glyphicon-minus-sign"></span></a>
<?php endif; ?>
<?php if (!$ignored): ?>
                    <span data-toggle="modal" data-target="#podiumModalIgnore" data-url="<?php echo Url::to(['members/ignore', 'id' => $user->id]); ?>"><button class="btn btn-danger btn-lg" data-toggle="tooltip" data-placement="top" title="<?php echo Yii::t('podium/view', 'Ignore Member'); ?>"><span class="glyphicon glyphicon-ban-circle"></span></button></span>
<?php else: ?>
                    <span data-toggle="modal" data-target="#podiumModalUnIgnore" data-url="<?php echo Url::to(['members/ignore', 'id' => $user->id]); ?>"><button class="btn btn-success btn-lg" data-toggle="tooltip" data-placement="top" title="<?php echo Yii::t('podium/view', 'Unignore Member'); ?>"><span class="glyphicon glyphicon-ok-circle"></span></button></span>
<?php endif; ?>
<?php else: ?>
                    <a href="#" class="btn btn-lg disabled text-muted"><span class="glyphicon glyphicon-ban-circle"></span></a>
<?php endif; ?>
                </div>
<?php if ($ignored): ?>
                <h4 class="text-danger"><?php echo Yii::t('podium/view', 'You are ignoring this user.'); ?></h4>
<?php endif; ?>
<?php if ($friend): ?>
                <h4 class="text-success"><?php echo Yii::t('podium/view', 'You are friends with this user.'); ?></h4>
<?php endif; ?>
<?php endif; ?>
                <h2>
                    <?php echo Html::encode($user->podiumName); ?>
                    <small><?php echo Helper::roleLabel($user->role); ?></small>
                </h2>

                <p><?php echo Yii::t('podium/view', 'Whereabouts'); ?>: <?php echo !empty($user->userProfile) && !empty($user->userProfile->location) ? Html::encode($user->userProfile->location) : '-'; ?></p>

                <p><?php echo Yii::t('podium/view', 'Member since {date}', ['date' => Podium::getInstance()->formatter->asDatetime($user->created_at, 'long')]); ?> (<?php echo Podium::getInstance()->formatter->asRelativeTime($user->created_at); ?>)</p>
<?php if ($user->status !== User::STATUS_REGISTERED): ?>
                <p>
                    <a href="<?php echo Url::to(['members/threads', 'id' => $user->id, 'slug' => $user->podiumSlug]); ?>" class="btn btn-default"><span class="glyphicon glyphicon-search"></span> <?php echo Yii::t('podium/view', 'Find all threads started by {name}', ['name' => Html::encode($user->podiumName)]); ?></a>
                    <a href="<?php echo Url::to(['members/posts', 'id' => $user->id, 'slug' => $user->podiumSlug]); ?>" class="btn btn-default"><span class="glyphicon glyphicon-search"></span> <?php echo Yii::t('podium/view', 'Find all posts created by {name}', ['name' => Html::encode($user->podiumName)]); ?></a>
                </p>
<?php endif; ?>
    </div>
</div>
<?php if (!Podium::getInstance()->user->isGuest): ?>
<?php Modal::begin([
    'id'                   => 'podiumModalIgnore',
    'header'               => Yii::t('podium/view', 'Ignore user'),
    'footer'               => Yii::t('podium/view', 'Ignore user'),
    'footerConfirmOptions' => ['class' => 'btn btn-danger', 'id' => 'ignoreUrl']
 ]); ?>
<p><?php echo Yii::t('podium/view', 'Are you sure you want to ignore this user?'); ?></p>
<p><?php echo Yii::t('podium/view', 'The user will not be able to send you messages.'); ?></p>
<p><strong><?php echo Yii::t('podium/view', 'You can always unignore the user if you change your mind later on.'); ?></strong></p>
<?php Modal::end(); ?>
<?php Modal::begin([
    'id'                   => 'podiumModalUnIgnore',
    'header'               => Yii::t('podium/view', 'Unignore user'),
    'footer'               => Yii::t('podium/view', 'Unignore user'),
    'footerConfirmOptions' => ['class' => 'btn btn-success', 'id' => 'unignoreUrl']
 ]); ?>
<p><?php echo Yii::t('podium/view', 'Are you sure you want to ignore this user?'); ?></p>
<p><?php echo Yii::t('podium/view', 'The user will not be able to send you messages.'); ?></p>
<p><strong><?php echo Yii::t('podium/view', 'You can always unignore the user if you change your mind later on.'); ?></strong></p>
<?php Modal::end(); ?>
<?php endif;
