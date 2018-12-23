<?php

use core\widgets\DateTime\DateTimeWidget;
use kartik\select2\Select2;
use trntv\filekit\widget\Upload;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/**
 * @var $this       yii\web\View
 * @var $model      core\models\Article
 * @var $categories core\models\ArticleCategory[]
 */

?>

<?php $form = ActiveForm::begin([
    'enableClientValidation' => false,
    'enableAjaxValidation'   => true,
]); ?>

<?php echo $form->field($model, 'title')->textInput(['maxlength' => true]); ?>

<?php echo $form->field($model, 'slug')
    ->hint(Yii::t('backend', 'If you\'ll leave this field empty, slug will be generated automatically'))
    ->textInput(['maxlength' => true]); ?>

<div class="row">
    <div class="col">
        <?php echo $form->field($model, 'category_id')->dropDownList(\yii\helpers\ArrayHelper::map(
            $categories,
            'id',
            'title'
        ), ['prompt' => '']); ?>
    </div>
</div>

<?php echo $form->field($model, 'announce')->textInput(['maxlength' => true]); ?>

<?php echo $form->field($model, 'body')->widget(
    \yii\imperavi\Widget::class,
    [
        'plugins' => ['fullscreen', 'fontcolor', 'video'],
        'options' => [
            'minHeight'       => 400,
            'maxHeight'       => 400,
            'buttonSource'    => true,
            'convertDivs'     => false,
            'removeEmptyTags' => true,
            'imageUpload'     => Yii::$app->urlManager->createUrl(['/file/storage/upload-imperavi']),
        ],
    ]
); ?>

<?php echo $form->field($model, 'thumbnail')->widget(
    Upload::class,
    [
        'url'         => ['/file/storage/upload'],
        'maxFileSize' => 5000000, // 5 MiB
    ]);
?>

<?php echo $form->field($model, 'attachments')->widget(
    Upload::class,
    [
        'url'              => ['/file/storage/upload'],
        'sortable'         => true,
        'maxFileSize'      => 10000000, // 10 MiB
        'maxNumberOfFiles' => 10,
    ]);
?>

<?php echo $form->field($model, 'view')->textInput(['maxlength' => true]); ?>

<?php
$field = $form->field($model, 'status', ['options' => [
    'class' => 'position-relative'
]]);
$field->template = '{input} {label}';
echo $field->checkbox([], false)->label($model->getAttributeLabel('status'),[
    'class' => 'checkbox-label'
]);
?>

<?php echo $form->field($model, 'published_at')->widget(
    DateTimeWidget::class,
    [
        'phpDatetimeFormat' => 'yyyy-MM-dd\'T\'HH:mm:ssZZZZZ',
    ]
); ?>

<div class="form-group">
    <?php echo Html::submitButton(
        $model->isNewRecord ? Yii::t('backend', 'Create') : Yii::t('backend', 'Update'),
        ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']); ?>
</div>

<?php ActiveForm::end(); ?>
