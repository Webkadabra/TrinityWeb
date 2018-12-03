<?php

use kartik\date\DatePicker;

$answers = 0;
$options = [];
for ($a = 1; $a <= 10; $a++) {
    $opts = ['placeholder' => Yii::t('podium/view', 'Leave empty to remove')];
    $opts['id'] = 'thread-poll_answers' . ($a > 1 ? '_' . $a : '');
    if (!empty($model->$pollAnswers[$a - 1])) {
        $opts['value'] = $model->$pollAnswers[$a - 1];
        $answers++;
    } else {
        $opts['value'] = null;
    }
    $options[$a] = $opts;
}
$answers = max([2, $answers]);
$this->registerJs(<<<JS
var answers = $answers; $(".podium-poll-plus button").click(function(e) { e.preventDefault(); answers++; if ($(".podium-poll-opt-" + answers).length) { $(".podium-poll-opt-" + answers).removeClass("d-none"); } if (answers >= 10) { $(".podium-poll-plus").addClass("d-none"); }});
JS
);

$fieldLayoutLong = [
    'labelOptions' => ['class' => 'control-label col-sm-3'],
    'template' => "{label}\n<div class=\"col-sm-9\">{input}\n{hint}\n{error}</div>"
];
$fieldLayoutShort = [
    'labelOptions' => ['class' => 'control-label col-sm-3'],
    'template' => "{label}\n<div class=\"col-sm-3\">{input}\n{hint}\n{error}</div>"
];

?>
<div class="row">
    <div class="col">
        <?= $form->field($model, $pollQuestion, $fieldLayoutLong); ?>
    </div>
</div>
<div class="row">
    <div class="col">
        <?= $form->field($model, $pollVotes, $fieldLayoutShort); ?>
    </div>
</div>
<div class="row no-gutters">
    <div class="col pl-3">
        <?php
        $field = $form->field($model, $pollHidden, ['options' => [
            'class' => 'position-relative'
        ]]);
        $field->template = '{input} {label}';
        echo $field->checkbox([], false)->label($pollHidden,[
            'class' => 'checkbox-label'
        ])
        ?>
    </div>
</div>
<div class="row">
    <div class="col">
        <?= $form->field($model, $pollEnd, $fieldLayoutShort)->widget(DatePicker::class, [
            'removeButton' => false, 'pluginOptions' => ['autoclose' => true, 'format' => 'yyyy-mm-dd']
        ]); ?>
    </div>
</div>
<?php foreach ($options as $index => $option): ?>
<div class="row <?= $index > 2 ? 'podium-poll-opt-' . $index : '' ?> <?= $option['value'] === null && $index > 2 ? 'd-none' : '' ?>">
    <div class="col">
        <?= $form->field($model, $pollAnswers .'[]', $fieldLayoutLong)
                ->label(Yii::t('podium/view', 'Option #{n}', ['n' => $index]), ['for' => $option['id']])
                ->textInput($option); ?>
    </div>
</div>
<?php endforeach; ?>
<div class="row podium-poll-plus">
    <div class="col-sm-offset-3 col-sm-9">
        <button class="btn btn-default btn-xs"><span class="glyphicon glyphicon-plus"></span> <?= Yii::t('podium/view', 'One more'); ?></button>
    </div>
</div>