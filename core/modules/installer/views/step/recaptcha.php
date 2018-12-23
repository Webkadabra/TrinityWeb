<?php
use core\modules\installer\models\config\RecaptchaForm;
use yii\widgets\ActiveForm;

/** @var $model  RecaptchaForm */

?>
<div id="card-form" class="card card-default">
    <div class="card-header">
        <h2 class="text-center">
            <?php echo Yii::t('installer','Recaptcha Configuration');?>
        </h2>
    </div>
    <div class="card-body">
        <?php
        $form = ActiveForm::begin([
            'id' => 'recaptcha-form',
        ]);
        ?>
        <div class="row no-gutters form-group">
            <div class="col">
                <?php echo $form->field($model, 'siteKey', [
                    'template' => '<i class="fas fa-key input-icon"></i>{input}{hint}{error}'
                ])->textInput([
                    'class'       => 'form-control parent-input-icon',
                    'placeholder' => mb_strtolower($model->getAttributeLabel('siteKey'))
                ]); ?>
            </div>
            <div class="col-1 vert-split"></div>
            <div class="col">
                <?php echo $form->field($model, 'secret', [
                    'template' => '<i class="fas fa-user-secret input-icon"></i>{input}{hint}{error}'
                ])->textInput([
                    'class'       => 'form-control parent-input-icon',
                    'placeholder' => $model->getAttributeLabel('secret')
                ]); ?>
            </div>
        </div>
        <div class="text-center">
            <?php echo \yii\helpers\Html::submitButton(Yii::t('installer','Next step'), ['class' => 'btn btn-primary']); ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>