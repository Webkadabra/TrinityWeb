<?php

use himiklab\yii2\recaptcha\ReCaptcha;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model \frontend\models\forms\LoginForm */

$this->params['breadcrumbs'][] = $this->title;
\yii\widgets\Pjax::begin(['id' => 'auth-login']);
?>
    <div class="row justify-content-sm-center">
        <div class="col-md-10">
            <?php $form = ActiveForm::begin([
                'id'      => 'login-form',
                'action'  => ['/auth/sign-in'],
                'options' => ['data-pjax' => true]
            ]); ?>
                <div class="text-center">
                    <h4><?php echo Yii::t('frontend','Sign-in');?></h4>
                </div>
                <?php echo $form->field($model, 'identity', [
                    'template' => '<i class="glyphicon glyphicon-user input-icon"></i>{input}{hint}{error}'
                ])->textInput([
                    'class'       => 'form-control parent-input-icon',
                    'placeholder' => $model->getAttributeLabel('identity')
                ]); ?>
                <?php echo $form->field($model, 'password', [
                    'template' => '<i class="fa fa-key input-icon"></i>{input}{hint}{error}',
                    'options'  => [
                        'class' => 'form-group'
                    ]
                ])->passwordInput([
                    'class'       => 'form-control parent-input-icon',
                    'placeholder' => $model->getAttributeLabel('password')
                ]); ?>
                <?php
                $captcha = Yii::$app->settings->get(Yii::$app->settings::APP_STATUS) === Yii::$app->settings::ENABLED ? true : false;
                if($captcha) {
                    ?>
                    <div class="row justify-content-center">
                        <div class="col-auto">
                            <?php echo $form->field($model, 'reCaptcha')->widget(
                                ReCaptcha::class,
                                [
                                    'siteKey' => Yii::$app->settings->get(Yii::$app->settings::APP_CAPTCHA_KEY),
                                    'theme'   => ReCaptcha::THEME_DARK
                                ]
                            )->label(false); ?>
                        </div>
                    </div>
                <?php
                }
                ?>
                <div class="row justify-content-center">
                    <div class="col-auto">
                        <?php
                        $field = $form->field($model, 'rememberMe', ['options' => [
                            'class' => 'position-relative'
                        ]]);
                        $field->template = '{input} {label}';
                        echo $field->checkbox([], false)->label($model->getAttributeLabel('rememberMe'),[
                            'class' => 'checkbox-label'
                        ]);?>
                    </div>
                </div>
                <div class="text-center">
                    <small>
                        <?php echo Yii::t('frontend', 'If you forgot your password you can reset it <a href="{link}" data-pjax="0">here</a>', [
                            'link'=> yii\helpers\Url::to(['/auth/request-password-reset'])
                        ]); ?>
                    </small>
                </div>
                <div class="form-group text-center">
                    <?php echo Html::submitButton(Yii::t('frontend', 'Login'), ['class' => 'btn btn-primary', 'name' => 'login-button']); ?>
                </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
<?php
\yii\widgets\Pjax::end();
?>
