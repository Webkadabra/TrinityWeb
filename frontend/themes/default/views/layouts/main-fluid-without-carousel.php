<?php

use core\widgets\Breadcrumbs;
use core\widgets\Alert;

use frontend\widgets\Marquee\MarqueeWidget;

/* @var $content string */
/* @var $this \yii\web\View */

$this->beginContent('@frontend/views/layouts/base.php')
?>
<div class="container mih-100">
    <div class="fix-header">
    </div>
    <div class="row mih-100">
        <div class="col-12">
            <?= Alert::widget() ?>
        </div>
        <div class="col-12 h-100">
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
            <?= MarqueeWidget::widget()?>
            <?= $content?>
        </div>
    </div>
</div>
<?php $this->endContent() ?>