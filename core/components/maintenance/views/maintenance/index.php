<?php
/**
 * @var string $maintenanceText
 * @var int|string $retryAfter
 */
?>
<div id="maintenance-content" style="margin-top: 10%">
    <p class="well">
        <?php echo Yii::t('common', $maintenanceText, [
            'retryAfter' => $retryAfter,
            'adminEmail' => Yii::$app->settings->get(Yii::$app->settings::APP_MAILER_ADMIN)
        ]) ?>
    </p>
</div>