<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/**
 * @var $this  yii\web\View
 * @var $model core\models\Page
 */

?>

<?php $form = ActiveForm::begin([
    'enableClientValidation' => false,
    'enableAjaxValidation'   => true,
]); ?>

<?php echo $form->field($model, 'title')->textInput(['maxlength' => true]); ?>

<?php echo $form->field($model, 'slug')->textInput(['maxlength' => true]); ?>

<?php echo $form->field($model, 'body')->widget(
    \yii\imperavi\Widget::class,
    [
        'plugins' => ['fullscreen', 'fontcolor', 'video'],
        'options' => [
            'minHeight'    => 400,
            'maxHeight'    => 400,
            'buttonSource' => true,
            'imageUpload'  => Yii::$app->urlManager->createUrl(['/file/storage/upload-imperavi']),
        ],
    ]
); ?>

<?php echo $form->field($model, 'view')->textInput(['maxlength' => true]); ?>

<?php
$field = $form->field($model, 'status', ['options' => [
    'class' => 'position-relative'
]]);
$field->template = '{input} {label}';
echo $field->checkbox([], false)->label($model->getAttributeLabel('status'),[
    'class' => 'checkbox-label'
]);?>


<div class="form-group">
    <?php echo Html::submitButton($model->isNewRecord ? Yii::t('backend', 'Create') : Yii::t('backend', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']); ?>
</div>

<?php ActiveForm::end(); ?>
