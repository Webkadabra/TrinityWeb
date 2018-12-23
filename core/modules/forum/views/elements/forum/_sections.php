<?php

/**
 * Podium Module
 * Yii 2 Forum Module
 */

?>
<div class="card-group" role="tablist" aria-multiselectable="true">
    <?php echo \yii\widgets\ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView'     => '/elements/forum/_section',
        'separator'    => "\n<br>\n",
        'options'      => ['class' => 'w-100'],
        'summary'      => '',
        'emptyText'    => '<h3>' . Yii::t('podium/view', 'No categories have been added yet.') . '</h3>',
    ]); ?>
</div>
