<?php

use yii\helpers\Html;

?>
<hr>
<p><strong><?php echo Yii::t('podium/view', 'Poll'); ?>: <?php echo Html::encode($model->pollQuestion); ?></strong></p>
<ul class="list-inline">
    <li class="list-inline-item"><small><?php echo Yii::t('podium/view', 'Number of votes'); ?>: <span class="badge"><?php echo Html::encode($model->pollVotes); ?></span></small></li>
<?php if ($model->pollHidden): ?>
    <li class="list-inline-item"><small><span class="glyphicon glyphicon-eye-close"></span> <?php echo Yii::t('podium/view', 'Results hidden before voting'); ?></small></li>
<?php else: ?>
    <li class="list-inline-item"><small><span class="glyphicon glyphicon-eye-open"></span> <?php echo Yii::t('podium/view', 'Results visible before voting'); ?></small></li>
<?php endif; ?>
    <li class="list-inline-item"><small>
        <span class="glyphicon glyphicon-calendar"></span>
        <?php echo Yii::t('podium/view', 'Poll ends at'); ?>:
        <?php echo empty($model->pollEnd) ? '-' : Html::encode($model->pollEnd) . ' 23:59'; ?>
    </small></li>
</ul>
<ul>
<?php foreach ($model->pollAnswers as $answer): ?>
<?php if (!empty($answer)): ?>
    <li><?php echo Html::encode($answer); ?></li>
<?php endif; ?>
<?php endforeach; ?>
</ul>