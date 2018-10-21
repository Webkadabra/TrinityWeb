<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\select2\Select2;
use yii\web\View;

use core\models\auth\Accounts;

use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $model core\models\UserProfile */
/* @var $form yii\bootstrap\ActiveForm */

$this->title = Yii::t('backend', 'Edit account');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="user-profile-form">

    <?php $form = ActiveForm::begin() ?>

    <div class="row">
        <div class="col-12 col-md-4">
            <?php echo $form->field($model, 'email') ?>
        </div>
    </div>

    <div class="row">
        <div class="col-12 col-md-2">
            <?php echo $form->field($model, 'password')->passwordInput() ?>
        </div>
        <div class="col-12 col-md-2">
            <?php echo $form->field($model, 'password_confirm')->passwordInput() ?>
        </div>
    </div>

    <div class="form-group">
        <?php echo Html::submitButton(Yii::t('backend', 'Update'), ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end() ?>

</div>
