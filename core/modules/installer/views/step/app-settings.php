<?php
use yii\widgets\ActiveForm;
/** @var $model \core\modules\installer\models\config\AppSettingsForm */
?>

<div id="card-form" class="card card-default">
    <div class="card-header">
        <h2 class="text-center">
            <?=Yii::t('installer','TrinityWeb settings')?>
        </h2>
    </div>
    <div class="card-body">
        <?php
        $form = ActiveForm::begin([
            'id' => 'app-settings',
        ]);
        ?>
        <div class="row justify-content-center">
            <div class="col-5 text-center">
                <?php echo $form->field($model, 'app_name', [
                    'template' => '{label}{input}{hint}{error}'
                ])->textInput([
                    'class' => 'form-control',
                    'placeholder' => mb_strtolower($model->getAttributeLabel('app_name'))
                ]) ?>
            </div>
        </div>
        <div class="text-center">
            <?= \yii\helpers\Html::submitButton(Yii::t('installer','Next step'), ['class' => 'btn btn-primary']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>