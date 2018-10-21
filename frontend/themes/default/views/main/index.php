<?php

use yii\widgets\ListView;

/* @var $this yii\web\View */

$this->title = Yii::t('frontend', 'Home');
?>

<div id="articles">
    <?php echo ListView::widget([
        'dataProvider' => $dataProvider,
        'pager' => [
            'hideOnSinglePage' => true,
        ],
        'layout' => "{items}\n{pager}",
        'itemView' => 'articles/_item'
    ])?>
</div>