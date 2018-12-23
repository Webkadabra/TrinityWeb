<?php

/**
 * Podium Module
 * Yii 2 Forum Module
 */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$this->title = Yii::t('podium/view', 'Change password');
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="row">
    <div class="col-sm-12">
        <div class="alert alert-info">
            <span class="glyphicon glyphicon-info-sign"></span> <?php echo Yii::t('podium/view', 'Enter new password for your account. Password must contain uppercase and lowercase letter, digit, and be at least {chars} characters long.', ['chars' => 6]); ?>
        </div>
    </div>
    <div class="col-sm-4 col-sm-offset-4">
        <?php $form = ActiveForm::begin(['id' => 'password-form']); ?>
            <div class="form-group">
                <?php echo $form->field($model, 'password')->passwordInput(['placeholder' => Yii::t('podium/view', 'New password'), 'autofocus' => true])->label(false); ?>
            </div>
            <div class="form-group">
                <?php echo $form->field($model, 'passwordRepeat')->passwordInput(['placeholder' => Yii::t('podium/view', 'Repeat new password')])->label(false); ?>
            </div>
            <div class="form-group">
                <?php echo Html::submitButton('<span class="glyphicon glyphicon-ok-sign"></span> ' . Yii::t('podium/view', 'Change password'), ['class' => 'btn btn-block btn-danger', 'name' => 'password-button']); ?>
            </div>
        <?php ActiveForm::end(); ?>
    </div>
</div><br>
