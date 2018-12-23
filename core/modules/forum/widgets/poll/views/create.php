<?php

use yii\helpers\Html;

$this->registerJs(<<<'JS'
$(".podium-poll-add").click(function(e) { e.preventDefault(); $(".new-poll").removeClass("d-none"); $("#poll_added").val(1); $(this).addClass("d-none"); });
$(".podium-poll-discard").click(function(e) { e.preventDefault(); $(".new-poll").addClass("d-none"); $("#poll_added").val(0); $(".podium-poll-add").removeClass("d-none"); });
JS
);

echo Html::activeHiddenInput($model, 'pollAdded', ['id' => 'poll_added']);
?>
<button class="btn btn-success podium-poll-add <?php echo $model->pollAdded ? 'd-none' : ''; ?>">
    <span class="glyphicon glyphicon-tasks"></span> <?php echo Yii::t('podium/view', 'Add poll to this thread'); ?>
</button>

<div class="new-poll <?php echo $model->pollAdded ? '' : 'd-none'; ?>">
    <div class="panel panel-default">
        <div class="panel-heading">
            <button class="btn btn-xs btn-danger float-right podium-poll-discard"><span class="glyphicon glyphicon-remove"></span> <?php echo Yii::t('podium/view', 'Discard poll'); ?></button>
            <strong><?php echo Yii::t('podium/view', 'New poll'); ?></strong>
        </div>
        <div class="panel-body">
            <?php echo $this->render('_form', [
                'form'         => $form,
                'model'        => $model,
                'pollQuestion' => 'pollQuestion',
                'pollVotes'    => 'pollVotes',
                'pollHidden'   => 'pollHidden',
                'pollEnd'      => 'pollEnd',
                'pollAnswers'  => 'pollAnswers',
            ]); ?>
        </div>
    </div>
</div>
