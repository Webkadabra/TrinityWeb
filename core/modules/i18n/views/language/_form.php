<?php
/**
 * @author Lajos Molnár <lajax.m@gmail.com>
 *
 * @since 1.3
 */
use core\modules\i18n\models\Language;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model core\modules\i18n\models\Language */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="language-form col-sm-6">

    <?php $form = ActiveForm::begin([
        'enableAjaxValidation' => true,
    ]); ?>

    <?php echo $form->field($model, 'language_id')->textInput(['maxlength' => 5]); ?>

    <?php echo $form->field($model, 'language')->textInput(['maxlength' => 3]); ?>

    <?php echo $form->field($model, 'country')->textInput(['maxlength' => 3]); ?>

    <?php echo $form->field($model, 'name')->textInput(['maxlength' => 32]); ?>

    <?php echo $form->field($model, 'name_ascii')->textInput(['maxlength' => 32]); ?>

    <?php echo $form->field($model, 'status')->dropDownList(Language::getStatusNames()); ?>

    <div class="form-group">
        <?php echo Html::submitButton($model->isNewRecord ? Yii::t('language', 'Create') : Yii::t('language', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']); ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>