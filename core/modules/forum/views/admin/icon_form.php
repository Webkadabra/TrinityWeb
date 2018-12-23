<?php

use core\modules\forum\models\db\IconsActiveRecord;
use trntv\filekit\widget\Upload;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
?>

<script type="text/javascript">
    function show_input(element) {
        if($(element).val() == <?php echo IconsActiveRecord::TYPE_FONT;?>) {
            $('#icon_input_string').show();
            $('#picture_input').d-none();
        } else {
            $('#icon_input_string').d-none();
            $('#picture_input').show();
        }
    }
</script>

<div class="icons-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php echo $form->field($model, 'icon')->textInput(['maxlength' => true]); ?>
    
    <?php echo $form->field($model, 'icon_type')->dropDownList(IconsActiveRecord::getTypes(), [
        'onchange' => 'show_input(this);',
    ]); ?>
    <div id="icon_input_string" style="<?php echo ($model->icon_type === IconsActiveRecord::TYPE_IMAGE ? 'display:none;': '');?>">
        <pre>
    https://fontawesome.com/icons
    https://getbootstrap.com/docs/3.3/components/#glyphicons
    need input -> class like "fas fa-pen"</pre>
        <?php echo $form->field($model, 'icon_string')->textInput(['maxlength' => true, 'id' => 'icon_string']); ?>
    </div>
    <div id="picture_input" style="<?php echo ($model->icon_type === IconsActiveRecord::TYPE_FONT ? 'display:none;': '');?>">
        <?php echo $form->field($model, 'picture')->widget(
            Upload::className(),
            [
                'url'         => ['/file-storage/upload'],
                'maxFileSize' => 5000000, // 5 MiB
            ]);
        ?>
    </div>

    <div class="form-group">
        <?php echo Html::submitButton(Yii::t('common', 'Save'), ['class' => 'btn btn-success']); ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
