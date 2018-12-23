<?php

use core\widgets\Alert;
use core\widgets\Breadcrumbs;
use frontend\widgets\Marquee\MarqueeWidget;

/* @var $content string */
/* @var $this \yii\web\View */

$this->beginContent('@frontend/views/layouts/base.php');
?>
<div class="container mih-100">
    <div class="fix-header">
    </div>
    <div class="row mih-100">
        <div class="col-12">
            <?php echo Alert::widget(); ?>
        </div>
        <div class="col-12 h-100">
            <?php echo Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]); ?>
            <?php echo MarqueeWidget::widget();?>
            <?php echo $content;?>
        </div>
    </div>
</div>
<?php $this->endContent(); ?>