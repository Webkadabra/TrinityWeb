<?php

/**
 * Podium Module
 * Yii 2 Forum Module
 */

use core\modules\forum\helpers\Helper;
use core\modules\forum\Podium;
use core\modules\forum\widgets\Avatar;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = Yii::t('podium/view', 'My Profile');
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="row">
    <div class="col-md-3 col-sm-4">
        <?php echo $this->render('/elements/profile/_navbar', ['active' => 'profile']); ?>
    </div>
    <div class="col-md-6 col-sm-8">
        <div class="panel panel-default">
            <div class="panel-body">
                <h2>
                    <?php echo Html::encode($model->podiumName); ?>
                    <small>
                        <?php echo Html::encode($model->email); ?>
                        <?php echo Helper::roleLabel($model->role); ?>
                    </small>
                </h2>
                <p><?php echo Yii::t('podium/view', 'Whereabouts'); ?>: <?php echo !empty($model->userProfile) && !empty($model->userProfile->location) ? Html::encode($model->userProfile->location) : '-'; ?></p>
                <p><?php echo Yii::t('podium/view', 'Member since {date}', ['date' => Podium::getInstance()->formatter->asDatetime($model->created_at, 'long')]); ?> (<?php echo Podium::getInstance()->formatter->asRelativeTime($model->created_at); ?>)</p>
                <p>
                    <a href="<?php echo Url::to(['members/threads', 'id' => $model->id, 'slug' => $model->podiumSlug]); ?>" class="btn btn-default"><span class="glyphicon glyphicon-search"></span> <?php echo Yii::t('podium/view', 'Show all threads started by me'); ?></a>
                    <a href="<?php echo Url::to(['members/posts', 'id' => $model->id, 'slug' => $model->podiumSlug]); ?>" class="btn btn-default"><span class="glyphicon glyphicon-search"></span> <?php echo Yii::t('podium/view', 'Show all posts created by me'); ?></a>
                </p>
            </div>
            <div class="panel-footer">
                <ul class="list-inline">
                    <li><?php echo Yii::t('podium/view', 'Threads'); ?> <span class="badge"><?php echo $model->threadsCount; ?></span></li>
                    <li><?php echo Yii::t('podium/view', 'Posts'); ?> <span class="badge"><?php echo $model->postsCount; ?></span></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="col-md-3 d-sm-none d-none">
        <?php echo Avatar::widget([
            'author'   => $model,
            'showName' => false
        ]); ?>
    </div>
</div><br>
