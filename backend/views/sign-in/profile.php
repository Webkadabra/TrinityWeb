<?php

use core\models\UserProfile;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model core\models\UserProfile */
/* @var $form yii\bootstrap\ActiveForm */

$this->title = Yii::t('backend', 'Edit profile');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="user-profile-form">

    <?php $form = ActiveForm::begin() ?>
        <div class="row">
            <div class="col-auto">
                <?php echo $form->field($model, 'picture')->widget(\trntv\filekit\widget\Upload::class, [
                    'url'=>['avatar-upload']
                ]) ?>
            </div>
            <div class="col">
                <?php echo $form->field($model, 'locale')->dropDownlist(Yii::$app->i18nHelper::getIdentLocales()) ?>
                <?php echo $form->field($model, 'gender')->dropDownlist([
                    UserProfile::GENDER_FEMALE => Yii::t('backend', 'Female'),
                    UserProfile::GENDER_MALE => Yii::t('backend', 'Male')
                ]) ?>
            </div>
        </div>
    <div class="form-group">
        <?php echo Html::submitButton(Yii::t('backend', 'Update'), ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end() ?>

</div>
