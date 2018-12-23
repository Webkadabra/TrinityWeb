<?php

use yii\widgets\ActiveForm;

/** @var $model \core\modules\installer\models\config\MailerForm */
?>

<div id="card-form" class="card card-default">
    <div class="card-header">
        <h2 class="text-center">
            <?php echo Yii::t('installer','Mailer settings');?>
        </h2>
    </div>
    <div class="card-body">
        <?php
        $form = ActiveForm::begin([
            'id' => 'recaptcha-form',
        ]);
        ?>

        <div class="row justify-content-center">
            <div class="col-4 col-md-4">
                <?php echo $form->field($model, 'smtp_host')->textInput([
                    'autocomplete' => 'off',
                    'placeholder'  => mb_strtolower($model->getAttributeLabel('smtp_host')),
                    'class'        => 'form-control'])->error(false);
                ?>
            </div>
            <div class="col-4 col-md-3">
                <?php echo $form->field($model, 'smtp_port')->textInput([
                    'autocomplete' => 'off',
                    'placeholder'  => mb_strtolower($model->getAttributeLabel('smtp_port')),
                    'class'        => 'form-control'])->error(false);
                ?>
            </div>
            <div class="col-4 col-md-3">
                <?php echo $form->field($model, 'smtp_encrypt')->dropDownList([
                    ''    => 'None',
                    'tls' => 'TLS',
                    'ssl' => 'SSL'
                ],[
                    'autocomplete' => 'off',
                    'class'        => 'form-control'])->label(Yii::t('installer','Encrypt'))->error(false);
                ?>
            </div>
        </div>
        <hr/>

        <div class="row no-gutters form-group">
            <div class="col">
                <?php echo $form->field($model, 'email', [
                    'template' => '<i class="fas fa-user-plus input-icon"></i>{input}{hint}{error}'
                ])->textInput([
                    'class'       => 'form-control parent-input-icon',
                    'placeholder' => mb_strtolower($model->getAttributeLabel('email'))
                ]); ?>
                <hr/>
                <?php echo $form->field($model, 'robot_email', [
                    'template' => '<i class="fas fa-envelope input-icon"></i>{input}{hint}{error}'
                ])->textInput([
                    'class'       => 'form-control parent-input-icon',
                    'placeholder' => mb_strtolower($model->getAttributeLabel('robot_email'))
                ]); ?>
            </div>
            <div class="col-1 vert-split"></div>
            <div class="col">
                <?php echo $form->field($model, 'smtp_username', [
                    'template' => '<i class="fas fa-user input-icon"></i>{input}{hint}{error}'
                ])->textInput([
                    'class'       => 'form-control parent-input-icon',
                    'placeholder' => $model->getAttributeLabel('smtp_username')
                ]); ?>
                <hr/>
                <?php echo $form->field($model, 'smtp_password', [
                    'template' => '<i class="fas fa-key input-icon"></i>{input}{hint}{error}'
                ])->passwordInput([
                    'class'       => 'form-control parent-input-icon',
                    'placeholder' => $model->getAttributeLabel('smtp_password')
                ]); ?>
            </div>
        </div>
        <div class="text-center">
            <?php echo \yii\helpers\Html::submitButton(Yii::t('installer','Next step'), ['class' => 'btn btn-primary']); ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>