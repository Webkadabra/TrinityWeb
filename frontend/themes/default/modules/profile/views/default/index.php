<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use trntv\filekit\widget\Upload;

use core\models\UserProfile;

/* @var $this yii\web\View */
/* @var $model core\base\models\MultiModel */
/* @var $form yii\widgets\ActiveForm */

$this->title = Yii::t('frontend', 'User Settings')
?>

<div class="user-profile-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="row mt-2">
        <div class="col-12 col-md-4 col-lg-3">
            <?php echo $form->field($model->getModel('profile'), 'picture')->widget(
                Upload::class,
                [
                    'url' => ['avatar-upload']
                ]
            )?>
        </div>
        <div class="col-12 col-md-8 col-lg-9">
            <?php echo $form->field($model->getModel('profile'), 'locale')->dropDownlist(Yii::$app->i18nHelper::getIdentLocales()) ?>

            <?php echo $form->field($model->getModel('profile'), 'gender')->dropDownlist([
                UserProfile::GENDER_FEMALE => Yii::t('frontend', 'Female'),
                UserProfile::GENDER_MALE => Yii::t('frontend', 'Male')
            ], ['prompt' => '']) ?>

            <?php echo $form->field($model->getModel('account'), 'email') ?>
        </div>
    </div>
    <div class="form-group">
        <?php echo Html::submitButton(Yii::t('frontend', 'Update'), ['class' => 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>