<?php

/**
 * Podium Module
 * Yii 2 Forum Module
 */

use yii\helpers\Url;

$this->title = Yii::t('podium/view', 'New Installation');
$this->params['breadcrumbs'][] = ['label' => Yii::t('podium/view', 'Podium Installation'), 'url' => ['install/run']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['no-search']     = true;

$url = Url::to(['install/import']);
$this->registerJs(<<<JS
var nextStep = function(drop) {
    var label = 'success';
    var bg = '';
    jQuery.post('$url', {drop: drop}, null, 'json')
        .always(function() {
            if (drop !== true) {
                jQuery('#progressBar .progress-bar').removeClass('progress-bar-warning');
            }
        })
        .fail(function() {
            jQuery('#progressBar').addClass('d-none');
            jQuery('#installationError').removeClass('d-none');
        })
        .done(function(data) {
            if (data.type == 2) {
                label = 'danger';
                bg = 'list-group-item-danger';
            } else if (data.type == 1) {
                label = 'warning';
                bg = 'list-group-item-warning';
            }
            jQuery('#progressBar .progress-bar')
                .css('width', data.percent + '%')
                .attr('aria-valuenow', data.percent)
                .html(data.percent + '%');
            var row = '<li class="list-group-item ' + bg + '">'
                + '<span class="float-right label label-' + label + '">' + data.table + '</span> '
                + data.result
                + '</li>';
            jQuery('#installationProgress .list-group').prepend(row);
            if (data.type == 2) {
                jQuery('#progressBar .progress-bar').removeClass('active progress-bar-striped');
                jQuery('#installationFinishedError').removeClass('d-none');
            } else {
                if (data.percent < 100 || data.drop === true) {
                    nextStep(data.drop);
                } else {
                    jQuery('#progressBar .progress-bar').removeClass('active progress-bar-striped');
                    jQuery('#installationFinished').removeClass('d-none');
                }
            }
        });
};
jQuery('#installPodium').click(function(e) {
    e.preventDefault();
    jQuery('#startInstallation').addClass('d-none');
    jQuery('#installationResults').removeClass('d-none');
    jQuery('#progressBar .progress-bar').css('width', '10px');
    nextStep(false);
});
JS
);
?>
<div class="row" id="startInstallation">
    <div class="text-center col-sm-12">
        <div class="alert alert-warning">
            <span class="glyphicon glyphicon-exclamation-sign"></span> <?= Yii::t('podium/view', 'Seriously - back up your existing database first!') ?><br>
            <?= Yii::t('podium/view', 'Podium does its best to make sure your data is not corrupted but make a database copy just in case.') ?><br>
            <?= Yii::t('podium/view', 'You have been warned!') ?>*
        </div>
        <div class="form-group">
            <button id="installPodium" class="btn btn-success btn-lg"><span class="glyphicon glyphicon-import"></span> <?= Yii::t('podium/view', 'Start Podium Installation') ?></button>
        </div>
        <div class="form-group">
            <?= Yii::t('podium/view', 'Version to install') ?> <kbd><?= $version ?></kbd>
        </div>
        <div class="form-group text-muted">
            <small>* <?= Yii::t('podium/view', 'Podium cannot be held liable for any database damages that may result directly or indirectly from the installing process. Back up your data first!') ?></small>
        </div>
    </div>
</div>
<div class="row no-gutters d-none" id="installationResults">
    <div class="progress text-center col-sm-8 mx-auto" id="progressBar">
        <div class="progress-bar progress-bar-striped bg-danger progress-bar-animated" role="progressbar" style="width: 100%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">

        </div>
    </div>
    <div class="col-sm-8 col-sm-offset-2 d-none" id="installationError">
        <div class="alert alert-danger" role="alert"><?= Yii::t('podium/view', 'There was a major error during installation! Check your runtime log for details.') ?></div>
    </div>
    <div class="row d-none" id="installationFinished">
        <div class="text-center col-sm-12">
            <a href="<?= Url::to(['forum/index']) ?>" class="btn btn-success btn-lg"><span class="glyphicon glyphicon-ok-sign"></span> <?= Yii::t('podium/view', 'Installation finished') ?></a>
        </div>
    </div>
    <div class="row d-none" id="installationFinishedError">
        <div class="text-center col-sm-12">
            <button class="btn btn-danger btn-lg"><span class="glyphicon glyphicon-alert"></span> <?= Yii::t('podium/view', 'Errors during installation') ?></button>
        </div>
    </div><br>
    <div class="col-sm-8 col-sm-offset-2" id="installationProgress">
        <ul class="list-group"></ul>
    </div>
</div>
