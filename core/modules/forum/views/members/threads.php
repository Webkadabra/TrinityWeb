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
<div class="row">
    <div class="col-sm-12">
        <div class="card-group" role="tablist">
            <?php echo $this->render('/elements/members/_members_threads', ['user' => $user]); ?>
        </div>
    </div>
</div>
