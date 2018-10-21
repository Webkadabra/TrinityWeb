<?php
use yii\widgets\ActiveForm;
?>
<div class="card card-default">
    <div class="card-header">
        <h2 class="text-center">
            <?=Yii::t('installer','Congratulations! TrinityWeb installing complete!')?>
        </h2>
    </div>
    <div class="card-body">
        <div class="row no-gutters">
            <div class="ml-auto">
                <?php
                $form = ActiveForm::begin(['id' => 'submit-install-complete', 'options' => [
                    'class' => 'd-inline-block'
                ]]);
                ?>
                <?= \yii\helpers\Html::submitButton(Yii::t('installer','Go to website') . ' <i class="fa fa-arrow-circle-right"></i>', ['class' => 'btn btn-primary']) ?>
                <?php
                $form::end();
                ?>
            </div>
        </div>
    </div>
</div>