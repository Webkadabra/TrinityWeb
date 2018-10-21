<?php
/**
 * @author Lajos Molnár <lajax.m@gmail.com>
 *
 * @since 1.4
 */

/* @var $this \yii\web\View */
/* @var $newDataProvider \yii\data\ArrayDataProvider */

use core\widgets\GridView;

?>

<?php if ($newDataProvider->totalCount > 0) : ?>

    <?=

    GridView::widget([
        'id' => 'added-source',
        'dataProvider' => $newDataProvider,
        'tableOptions' => ['class' => 'table table-dark table-hover'],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'category',
            'message',
        ],
    ]);

    ?>

<?php endif ?>
