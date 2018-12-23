<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var backend\modules\rbac\models\searchs\Menu $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="menu-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?php echo $form->field($model, 'id'); ?>

    <?php echo $form->field($model, 'name'); ?>

    <?php echo $form->field($model, 'parent'); ?>

    <?php echo $form->field($model, 'route'); ?>

    <?php echo $form->field($model, 'data'); ?>

    <div class="form-group">
        <?php echo Html::submitButton(Yii::t('rbac-admin', 'Search'), ['class' => 'btn btn-primary']); ?>
        <?php echo Html::resetButton(Yii::t('rbac-admin', 'Reset'), ['class' => 'btn btn-default']); ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
