<?php

use core\modules\forum\models\ThreadView;
use core\modules\forum\widgets\Readers;
use yii\helpers\Url;
use yii\widgets\ListView;

$this->title = Yii::t('podium/view', 'Unread posts');
$this->params['breadcrumbs'][] = ['label' => Yii::t('podium/view', 'Main Forum'), 'url' => ['forum/index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="row">
    <div class="col-sm-12 text-right">
        <ul class="list-inline">
            <li><a href="<?php echo Url::to(['forum/mark-seen']); ?>" class="btn btn-warning btn-sm"><span class="glyphicon glyphicon-eye-open"></span> <?php echo Yii::t('podium/view', 'Mark all as seen'); ?></a></li>
        </ul>
    </div>
</div>
<div class="card">
    <div class="card-header" role="tab" id="unreadThreads">
        <h4 class="card-title"><?php echo Yii::t('podium/view', 'Unread posts'); ?></h4>
    </div>
    <div id="collapseUnread" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="unreadThreads">
        <table class="table table-hover">
            <?php echo $this->render('/elements/forum/_thread_header'); ?>
            <?php echo ListView::widget([
                'dataProvider'     => (new ThreadView())->search(),
                'itemView'         => '/elements/forum/_thread',
                'summary'          => '',
                'emptyText'        => Yii::t('podium/view', 'No more unread posts at the moment.'),
                'emptyTextOptions' => ['tag' => 'td', 'class' => 'text-muted', 'colspan' => 4],
                'options'          => ['tag' => 'tbody'],
                'itemOptions'      => ['tag' => 'tr', 'class' => 'podium-thread-line']
            ]); ?>
        </table>
    </div>
</div>
<div class="card">
    <div class="card-body small">
        <ul class="list-inline float-right">
            <li class="list-inline-item">
                <a href="<?php echo Url::to(['forum/index']); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo Yii::t('podium/view', 'Go to the main page'); ?>">
                    <span class="glyphicon glyphicon-home"></span>
                </a>
            </li>
            <li class="list-inline-item">
                <a href="#top" data-toggle="tooltip" data-placement="top" title="<?php echo Yii::t('podium/view', 'Go to the top'); ?>">
                    <span class="glyphicon glyphicon-arrow-up"></span>
                </a>
            </li>
        </ul>
        <?php echo Readers::widget(['what' => 'unread']); ?>
    </div>
</div>