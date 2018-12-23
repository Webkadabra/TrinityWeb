<?php

/**
 * Podium Module
 * Yii 2 Forum Module
 */

use yii\helpers\Url;

$this->title = Yii::t('podium/view', 'Threads started by {name}', ['name' => $user->podiumName]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('podium/view', 'Members List'), 'url' => ['members/index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('podium/view', 'Member View'), 'url' => ['members/view', 'id' => $user->id, 'slug' => $user->podiumSlug]];
$this->params['breadcrumbs'][] = $this->title;

?>
<ul class="nav mr-auto">
    <li role="presentation" class="nav-item"><a href="<?php echo Url::to(['members/index']); ?>" class="nav-link"><span class="glyphicon glyphicon-user"></span> <?php echo Yii::t('podium/view', 'Members List'); ?></a></li>
    <li role="presentation" class="nav-item"><a href="<?php echo Url::to(['members/mods']); ?>" class="nav-link"><span class="glyphicon glyphicon-scissors"></span> <?php echo Yii::t('podium/view', 'Moderation Team'); ?></a></li>
    <li role="presentation" class="nav-item"><a href="<?php echo Url::to(['members/view', 'id' => $user->id, 'slug' => $user->podiumSlug]); ?>" class="nav-link"><span class="glyphicon glyphicon-eye-open"></span> <?php echo Yii::t('podium/view', 'Member View'); ?></a></li>
    <li role="presentation" class="active nav-item"><a href="#" class="nav-link"><span class="glyphicon glyphicon-comment"></span> <?php echo Yii::t('podium/view', 'Threads started by {name}', ['name' => $user->podiumName]); ?></a></li>
</ul>
<br>
<div class="row">
    <div class="col-sm-12">
        <div class="card-group" role="tablist">
            <?php echo $this->render('/elements/members/_members_threads', ['user' => $user]); ?>
        </div>
    </div>
</div>
