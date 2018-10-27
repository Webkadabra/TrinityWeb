<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/**
 * @var $this       yii\web\View
 * @var $model      core\models\ArticleCategory
 * @var $categories core\models\ArticleCategory[]
 */

?>

<?php $form = ActiveForm::begin([
    'enableClientValidation' => false,
    'enableAjaxValidation' => true,
]); ?>

<?php echo $form->field($model, 'title')->textInput(['maxlength' => 512]) ?>

<?php echo $form->field($model, 'slug')
    ->hint(Yii::t('backend', 'If you\'ll leave this field empty, slug will be generated automatically'))
    ->textInput(['maxlength' => 1024]) ?>

<?php echo $form->field($model, 'parent_id')->dropDownList($categories, ['prompt' => '']) ?>

<?php
$field = $form->field($model, 'status', ['options' => [
    'class' => 'position-relative'
]]);
$field->template = '{input} {label}';
echo $field->checkbox([], false)->label($model->getAttributeLabel('status'),[
    'class' => 'checkbox-label'
])
?>

<div class="form-group">
    <?php echo Html::submitButton($model->isNewRecord ? Yii::t('backend', 'Create') : Yii::t('backend', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end() ?>
