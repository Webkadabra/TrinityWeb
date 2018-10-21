<?php

use yii\widgets\ActiveForm;

/** @var \core\modules\installer\models\setup\SignUpForm $model */
?>
<div id="card-form" class="card card-default">
    <div class="card-header">
        <h2 class="text-center">
            <?=Yii::t('installer','Creating administrator account')?>
        </h2>
    </div>
    <div class="card-body">

        <p><?=Yii::t('installer','You\'re almost done. In the last step you have to fill out the form to create an admin account. With this account you can manage the whole website.')?></p>

        <?php
        $form = ActiveForm::begin([
            'id' => 'admin-account-form',
        ]);
        ?>
            <div class="row no-gutters form-group">
                <div class="col">
                    <?php echo $form->field($model, 'username', [
                        'template' => '<i class="fas fa-user input-icon"></i>{input}{hint}{error}'
                    ])->textInput([
                        'class' => 'form-control parent-input-icon',
                        'placeholder' => mb_strtolower(Yii::t('installer','Username'))
                    ])?>
                    <hr/>
                    <?php echo $form->field($model, 'password', [
                        'template' => '<i class="fas fa-key input-icon"></i>{input}{hint}{error}'
                    ])->passwordInput([
                        'class' => 'form-control parent-input-icon',
                        'placeholder' => mb_strtolower(Yii::t('installer','Password'))
                    ]) ?>
                </div>
                <div class="col-1 vert-split"></div>
                <div class="col">
                    <?php echo $form->field($model, 'email', [
                        'template' => '<i class="fas fa-envelope input-icon"></i>{input}{hint}{error}'
                    ])->textInput([
                        'class' => 'form-control parent-input-icon',
                        'placeholder' => mb_strtolower(Yii::t('installer','Email'))
                    ]) ?>
                    <hr/>
                    <?php echo $form->field($model, 'r_password', [
                        'template' => '<i class="fas fa-key input-icon"></i>{input}{hint}{error}'
                    ])->passwordInput([
                        'class' => 'form-control parent-input-icon',
                        'placeholder' => mb_strtolower(Yii::t('installer','Repeat password'))
                    ]) ?>
                </div>
            </div>
            <div class="text-center">
                <?= \yii\helpers\Html::submitButton(Yii::t('installer','Create Admin Account'), ['class' => 'btn btn-primary']) ?>
            </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>