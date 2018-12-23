<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \backend\models\LoginForm */

$this->title = Yii::t('backend', 'Sign In');
$this->params['breadcrumbs'][] = $this->title;
$this->params['body-class'] = 'login-page';
?>
<div class="row justify-content-center h-100">
    <div class="login-box col-8 col-sm-6 col-md-5 col-lg-3 align-self-center">
        <div class="header"></div>
        <div class="login-box-body">
            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
            <div class="body">
                <?php echo $form->field($model, 'username')->textInput([
                    'placeholder' => $model->getAttributeLabel('username')
                ])->error(false)->label(false); ?>
                <?php echo $form->field($model, 'password')->passwordInput([
                    'placeholder' => $model->getAttributeLabel('password')
                ])->error(false)->label(false); ?>
                <?php
                $field = $form->field($model, 'rememberMe', ['options' => [
                    'class' => 'position-relative'
                ]]);
                $field->template = '{input} {label}';
                echo $field->checkbox([], false)->label($model->getAttributeLabel('rememberMe'),[
                    'class' => 'checkbox-label'
                ]);?>
            </div>
            <div>
                <?php echo Html::submitButton(Yii::t('backend', 'Sign me in'), [
                    'class' => 'btn btn-primary btn-flat btn-block',
                    'name'  => 'login-button'
                ]); ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>