<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/**
 * @var $this  yii\web\View
 * @var $model core\models\WidgetCarousel
 */

?>

<?php $form = ActiveForm::begin([
    'enableClientValidation' => false,
    'enableAjaxValidation'   => true,
]); ?>

<?php echo $form->field($model, 'key')->textInput(['maxlength' => 1024]); ?>

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
