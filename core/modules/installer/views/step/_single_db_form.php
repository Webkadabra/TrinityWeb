<?php
/** @var $model \core\modules\installer\models\setup\DatabaseForm */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var $success */
?>

<div id="card-form" class="card card-default">
    <div class="card-header">
        <h2 class="text-center">
            <?=Yii::t('installer','{dynamic_name} database configuration!', [
                    'dynamic_name' => $model->_name,
            ])?>
        </h2>
    </div>
    <div class="card-body">

        <p><?=Yii::t('installer','Below you have to enter your databases connections details. If you’re not sure about these, please contact your administrator.')?></p>
        <?php
        if($model->scenario == $model::SCENARIO_ARMORY) {
            ?>
            <p class=""><?=Yii::t('installer','This step is optional. If you don`t have database - dump can be find <b>`console/dumps/armory.sql`</b>')?></p>
            <?php
        }
        $form = ActiveForm::begin([
            'id' => 'database-form',
            'enableClientValidation' => $model->scenario == $model::SCENARIO_DEFAULT ? true : false,
        ]);
        ?>

        <div class="row no-gutters form-group">
            <div class="col">
                <?php echo $form->field($model, 'host', [
                    'template' => '<i class="fas fa-server input-icon"></i>{input}{hint}{error}'
                ])->textInput([
                    'class' => 'form-control parent-input-icon',
                    'placeholder' => mb_strtolower($model->getAttributeLabel('host'))
                ]) ?>
                <hr/>
                <?php echo $form->field($model, 'database', [
                    'template' => '<i class="fas fa-database input-icon"></i>{input}{hint}{error}'
                ])->textInput([
                    'class' => 'form-control parent-input-icon',
                    'placeholder' => mb_strtolower($model->getAttributeLabel('database'))
                ]) ?>
                <hr/>
                <?php echo $form->field($model, 'login', [
                    'template' => '<i class="fas fa-user input-icon"></i>{input}{hint}{error}'
                ])->textInput([
                    'class' => 'form-control parent-input-icon',
                    'placeholder' => mb_strtolower($model->getAttributeLabel('login'))
                ]) ?>
            </div>
            <div class="col-1 vert-split"></div>
            <div class="col">
                <?php echo $form->field($model, 'port', [
                    'template' => '<i class="fas fa-plug input-icon"></i>{input}{hint}{error}'
                ])->textInput([
                    'class' => 'form-control parent-input-icon',
                    'placeholder' => $model->getAttributeLabel('port')
                ]) ?>
                <hr/>
                <?php echo $form->field($model, 'table_prefix', [
                    'template' => '<i class="fas fa-terminal input-icon"></i>{input}{hint}{error}'
                ])->textInput([
                    'class' => 'form-control parent-input-icon',
                    'placeholder' => mb_strtolower($model->getAttributeLabel('table_prefix'))
                ]) ?>
                <hr/>
                <?php echo $form->field($model, 'password', [
                    'template' => '<i class="fa fa-key input-icon"></i>{input}{hint}{error}'
                ])->passwordInput([
                    'class' => 'form-control parent-input-icon',
                    'placeholder' => mb_strtolower($model->getAttributeLabel('password'))
                ]) ?>
            </div>
        </div>
        <hr/>
        <?php if (!empty($errorMsg)) { ?>
            <div class="alert alert-danger">
                <strong><?= $errorMsg ?></strong>
            </div>
        <?php } ?>
        <div class="text-right">
            <?= Html::submitButton(Yii::t('installer','Next'), ['class' => 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>