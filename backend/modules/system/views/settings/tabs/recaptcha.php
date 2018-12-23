<?php
/**
 * @var $form \yii\bootstrap\ActiveForm
 * @var $model \backend\modules\system\models\SettingsModel
 * @var $this \yii\web\View
 */
?>
<div class="row justify-content-center">
    <div class="col-auto">
        <?php
        $field = $form->field($model, 'recaptcha_status', ['options' => [
            'class' => 'position-relative'
        ]]);
        $field->template = '{input} {label}';
        echo $field->checkbox([], false)->label($model->getAttributeLabel('recaptcha_status'),[
            'class'         => $model->recaptcha_status ? 'checkbox-label' : 'collapsed checkbox-label',
            'data-toggle'   => 'collapse',
            'data-target'   => '.collapseData',
            'aria-expanded' => $model->recaptcha_status ? 'true' : 'false',
            'aria-controls' => 'collapseData'
        ]);?>
    </div>
</div>
<div class="row justify-content-center">
    <div class="col-auto">
        <?php echo $form->field($model, 'recaptcha_key', [
            'template' => '<i class="fas fa-key input-icon"></i>{input}{hint}{error}',
            'options'  => ['class' => 'collapseData form-group' . ($model->recaptcha_status ? ' collapse show' : ' collapse')]
        ])->textInput([
            'class'       => 'form-control parent-input-icon',
            'placeholder' => $model->getAttributeLabel('recaptcha_key')
        ]); ?>
    </div>
</div>
<div class="row justify-content-center">
    <div class="col-auto">
        <?php echo $form->field($model, 'recaptcha_secret', [
            'template' => '<i class="fas fa-user-secret input-icon"></i>{input}{hint}{error}',
            'options'  => ['class' => 'collapseData form-group' . ($model->recaptcha_status ? ' collapse show' : ' collapse')]
        ])->textInput([
            'class'       => 'form-control parent-input-icon',
            'placeholder' => $model->getAttributeLabel('recaptcha_secret')
        ]); ?>
    </div>
</div>