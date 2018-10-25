<?php
/**
 * @var $form \yii\bootstrap\ActiveForm
 * @var $model \backend\modules\system\models\SettingsModel
 * @var $this \yii\web\View
 */
?>
<div class="row justify-content-center">
    <div class="col-auto">
        <?php echo $form->field($model, 'mailer_admin', [
            'template' => '<i class="fas fa-user-shield input-icon"></i>{input}{hint}{error}'
        ])->textInput([
            'class' => 'form-control parent-input-icon',
            'placeholder' => $model->getAttributeLabel('mailer_admin')
        ]) ?>
    </div>
</div>
<div class="row justify-content-center">
    <div class="col-auto">
        <?php echo $form->field($model, 'mailer_robot', [
            'template' => '<i class="fas fa-robot input-icon"></i>{input}{hint}{error}'
        ])->textInput([
            'class' => 'form-control parent-input-icon',
            'placeholder' => $model->getAttributeLabel('mailer_robot')
        ]) ?>
    </div>
</div>
