<?php

use yii\bootstrap\ActiveForm;
use yii\bootstrap\Progress;
use yii\helpers\Html;
use yii\helpers\Url;

$url = Url::to([Yii::$app->request->url]);
$this->registerJs(<<<JS
var process = function(percent) {
    $.ajax({
        url: "$url",
        type: "post",
        dataType: 'json',
        data: {percent: percent},
        beforeSend: function(result) {
            if(percent < 100) {
                $('#submitButtonForm').attr('disabled','disabled');
            }
        },
        error: function(result,status,error) {
            jQuery('#errorCard').removeClass('d-none');
        },
        success: function(data, status) {
            var progressBar = jQuery('#progressBar .progress-bar');
            if(!data.error_data) {
                progressBar.css('width', data.percent + '%').attr('aria-valuenow', data.percent).html(data.percent + '%');
                if (data.percent < 100 && data.percent != '' && data.percent != null ) {
                    process(data.percent);
                } else {
                    $('#submitButtonForm').attr('hidden','hidden');
                    $('#goNext').removeAttr('hidden');
                }
            } else {
                $('#errorCard').removeAttr('hidden');
                $('#errorCard .card-body code').text(JSON.stringify(JSON.parse(data.error_data), null, 4));
            }
        }
    });
};

jQuery('#submit-import-step').on('beforeSubmit', function() {
    jQuery('#startInstallation').addClass('d-none');
    jQuery('#installationResults').removeClass('d-none');
    jQuery('#progressBar .progress-bar').css('width', '0%');
    process(0);
    return false;
});
JS
);

?>
<div class="card card-default">
    <div class="card-header">
        <h2 class="text-center">
            <?php echo Yii::t('installer','Install Database');?>
        </h2>
    </div>
    <div class="card-body">
        <div id="progressBar" class="progress mb-2 mt-2">
            <div
                class="progress-bar progress-bar-animated progress-bar-striped"
                role="progressbar"
                style="width: 0%"
                aria-valuenow="1"
                aria-valuemin="0"
                aria-valuemax="100">
            </div>
        </div>
        <div id="errorCard" class="card card-default text-white" hidden>
            <div class="card-body">
                <code id="error">

                </code>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <?php
        $form = ActiveForm::begin([
            'id'                 => 'submit-import-step',
            'enableClientScript' => true,
        ]);
        ?>
        <div class="row no-gutters justify-content-between">
            <div class="col-auto">
                <?php echo Html::submitButton(Yii::t('installer','Start import') . ' <i class="fa fa-upload"></i>', [
                    'class'  => 'btn btn-primary', 'id' => 'submitButtonForm',
                    'hidden' => null,
                ]); ?>
            </div>
            <div class="col-auto">
                <?php echo Html::a(Yii::t('installer','Next') . ' <i class="fa fa-upload"></i>', ['auth-database'], [
                    'hidden' => 'hidden',
                    'class'  => 'btn btn-success',
                    'id'     => 'goNext'
                ]); ?>
            </div>
        </div>
        <?php
        $form::end();
        ?>
    </div>
</div>