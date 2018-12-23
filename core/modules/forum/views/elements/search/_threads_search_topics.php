<?php

/**
 * Podium Module
 * Yii 2 Forum Module
 */

?>
<table class="table table-hover">
    <?php echo $this->render('/elements/search/_thread_header'); ?>
    <?php echo $this->render('/elements/search/_thread_list', ['dataProvider' => $dataProvider, 'type' => $type]); ?>
</table>
