<?php

/**
 * Podium Module
 * Yii 2 Forum Module
 */

$this->title = Yii::t('podium/view', 'You have been banned!');

?>
<div class="jumbotron">
    <span style="font-size:5em" class="float-right glyphicon glyphicon-eye-close"></span>
    <h1><?php echo $this->title; ?></h1>
    <p><?php echo Yii::t('podium/view', 'Contact the administrator if you would like to get more details about your ban.'); ?></p>
</div>
