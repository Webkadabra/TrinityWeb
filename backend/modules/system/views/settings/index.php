<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use kartik\select2\Select2;

/**
 * @var $model \backend\modules\system\models\SettingsModel
 * @var $this \yii\web\View
 */

$this->title = Yii::t('backend', 'Application settings');
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="settings-block">
    <?php $form = ActiveForm::begin(['id' => 'settings-form']); ?>

        <div class="row">
            <div class="col-6 col-md-7">
                <?php echo $form->field($model, 'application_name', [
                    'template' => '<i class="fas fa-heading input-icon"></i>{input}{hint}{error}'
                ])->textInput([
                    'class' => 'form-control parent-input-icon',
                    'placeholder' => $model->getAttributeLabel('application_name')
                ]) ?>
            </div>
            <div class="col-12">
                <?php echo $form->field($model, 'application_announce')
                    ->textarea(['placeholder' => $model->getAttributeLabel('application_announce')]);
                ?>
            </div>
        </div
        <div>
            <ul class="nav nav-tabs justify-content-center" id="app_tabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="mailer-tab" data-toggle="tab" href="#mailer" role="tab" aria-controls="mailer" aria-selected="true">
                        <?=Yii::t('backend','Mailer')?>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="recaptcha-tab" data-toggle="tab" href="#recaptcha" role="tab" aria-controls="recaptcha" aria-selected="false">
                        <?=Yii::t('backend','REcaptcha')?>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="modules-tab" data-toggle="tab" href="#modules" role="tab" aria-controls="modules" aria-selected="false">
                        <?=Yii::t('backend','Modules')?>
                    </a>
                </li>
            </ul>
            <div class="tab-content mt-3" id="app_tabs_content">
                <div class="tab-pane fade show active" id="mailer" role="tabpanel" aria-labelledby="mailer-tab">
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
                </div>
                <div class="tab-pane fade" id="recaptcha" role="tabpanel" aria-labelledby="recaptcha-tab">
                    <div class="row justify-content-center">
                        <div class="col-auto">
                            <?php
                            $field = $form->field($model, 'recaptcha_status', ['options' => [
                                'class' => 'position-relative'
                            ]]);
                            $field->template = '{input} {label}';
                            echo $field->checkbox([], false)->label($model->getAttributeLabel('recaptcha_status'),[
                                'class' => $model->recaptcha_status ? 'checkbox-label' : 'collapsed checkbox-label',
                                'data-toggle' => 'collapse',
                                'data-target' => '.collapseData',
                                'aria-expanded' => $model->recaptcha_status ? 'true' : 'false',
                                'aria-controls' => 'collapseData'
                            ])?>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-auto">
                            <?php echo $form->field($model, 'recaptcha_key', [
                                'template' => '<i class="fas fa-key input-icon"></i>{input}{hint}{error}',
                                'options' => ['class' => 'collapseData form-group' . ($model->recaptcha_status ? ' collapse show' : ' collapse')]
                            ])->textInput([
                                'class' => 'form-control parent-input-icon',
                                'placeholder' => $model->getAttributeLabel('recaptcha_key')
                            ]) ?>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-auto">
                            <?php echo $form->field($model, 'recaptcha_secret', [
                                'template' => '<i class="fas fa-user-secret input-icon"></i>{input}{hint}{error}',
                                'options' => ['class' => 'collapseData form-group' . ($model->recaptcha_status ? ' collapse show' : ' collapse')]
                            ])->textInput([
                                'class' => 'form-control parent-input-icon',
                                'placeholder' => $model->getAttributeLabel('recaptcha_secret')
                            ]) ?>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="modules" role="tabpanel" aria-labelledby="modules-tab">
                    <div class="row justify-content-center">
                        <?php
                        foreach($model->modules as $key => $module) {
                            ?>
                            <div class="col-12 col-sm-6 col-md-6 col-lg-4">
                                <div class="card mt-3">
                                    <div class="card-body">
                                        <h5 class="card-title">
                                            <?=$module['label']?>
                                        </h5>
                                        <div class="position-relative">
                                            <input type="checkbox" id="Module_<?=$key?>_status" name="Module[<?=$key?>][status]" value="<?=$module['fields']['status']?>" <?=($module['fields']['status'] ? 'checked' : '')?>>
                                            <label class="checkbox-label" for="Module_<?=$key?>_status">
                                                <?=Yii::t('backend','Статус')?>
                                            </label>
                                        </div>
                                        <?php
                                        if(isset($module['fields']['per-page']) || isset($module['fields']['cache_duration'])) {
                                            ?>
                                            <div class="row">
                                                <?php
                                                if(isset($module['fields']['per-page'])) {
                                                    ?>
                                                    <div class="col-6">
                                                        <label class="form-check-label">
                                                            <?=Yii::t('backend','per-page')?>
                                                        </label>
                                                        <div class="form-group">
                                                            <i class="fas fa-copy input-icon"></i>
                                                            <input type="text" value="<?=$module['fields']['per-page']?>" class="form-control parent-input-icon" name="Module[<?=$key?>][per-page]">
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                                ?>
                                                <?php
                                                if(isset($module['fields']['cache_duration'])) {
                                                    ?>
                                                    <div class="col-6">
                                                        <label class="form-check-label">
                                                            <?=Yii::t('backend','Cache duration')?>
                                                        </label>
                                                        <div class="form-group">
                                                            <i class="fas fa-clock input-icon"></i>
                                                            <input type="text" value="<?=$module['fields']['cache_duration']?>" class="form-control parent-input-icon" name="Module[<?=$key?>][cache_duration]">
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                                ?>
                                            </div>
                                            <?php
                                        }
                                        ?>
                                        <p class="card-text">
                                            <?=Yii::t('backend',$module['description'])?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <hr/>
        <div class="row justify-content-center">
            <div class="col-auto">
                <?php
                $field = $form->field($model, 'application_theme');
                echo $field->dropDownList(Yii::$app->TrinityWeb::getThemes(),['class' => 'btn-sm form-control']);
                ?>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-auto">
                <?php
                $field = $form->field($model, 'application_maintenance', ['options' => [
                    'class' => 'position-relative'
                ]]);
                $field->template = '{input} {label}';
                echo $field->checkbox([], false)->label($model->getAttributeLabel('application_maintenance'),[
                    'class' => 'checkbox-label'
                ])?>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-auto">
                <?php echo Html::submitButton(Yii::t('backend', 'Save'), [
                    'class' => 'btn btn-primary btn-flat btn-block'
                ]) ?>
            </div>
        </div>
    <?php ActiveForm::end() ?>
</div>