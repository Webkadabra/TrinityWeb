<?php

use yii\bootstrap\ActiveForm;
use yii\bootstrap\Tabs;
use yii\helpers\Html;

/**
 * @var $model \backend\modules\system\models\SettingsModel
 * @var $auth_errorMsg array
 * @var $char_errorMsg array
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
        </div>
        <div>
            <?php
            echo Tabs::widget([
                'id' => 'app_tabs',
                'options' => [
                    'class' => 'justify-content-center'
                ],
                'itemOptions' => [
                    'class' => 'mt-3',
                ],
                'items' => [
                    [
                        'label' => Yii::t('backend','Mailer'),
                        'content' => $this->render('tabs/mailer',[
                            'form' => $form,
                            'model' => $model
                        ])
                    ],
                    [
                        'label' => Yii::t('backend','REcaptcha'),
                        'content' => $this->render('tabs/recaptcha',[
                            'form' => $form,
                            'model' => $model
                        ])
                    ],
                    [
                        'label' => Yii::t('backend','Modules'),
                        'content' => $this->render('tabs/modules',[
                            'model' => $model
                        ])
                    ],
                    [
                        'label' => Yii::t('backend','Auth connections'),
                        'content' => $this->render('tabs/auth_conn',[
                            'form' => $form,
                            'model' => $model,
                            'errorMsg' => $auth_errorMsg
                        ])
                    ],
                    [
                        'label' => Yii::t('backend','Char connections'),
                        'content' => $this->render('tabs/chars_conn',[
                            'form' => $form,
                            'model' => $model,
                            'errorMsg' => $char_errorMsg
                        ])
                    ]
                ]
            ]);
            ?>
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