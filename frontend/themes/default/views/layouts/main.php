<?php

use core\widgets\Alert;
use core\widgets\Breadcrumbs;
use core\widgets\DbCarousel;
use frontend\widgets\Marquee\MarqueeWidget;
use frontend\widgets\StatusServers\StatusServersWidget;

/* @var $content string */
/* @var $this \yii\web\View */

$this->beginContent('@frontend/views/layouts/base.php');
?>
<div id="carousel-container" class="fix-header">
    <?php echo DbCarousel::widget([
        'key'          => 'index',
        'assetManager' => Yii::$app->getAssetManager(),
        'options'      => [
            'class' => 'slide carousel-with-indicator',
        ]
    ]); ?>
</div>
<div class="container mih-100">
    <div class="row mih-100">
        <div class="col-12">
            <?php echo Alert::widget(); ?>
        </div>
        <div class="col-8 tw-left-side">
            <?php /*= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) */?>
            <?php echo MarqueeWidget::widget();?>
            <?php echo $content;?>
        </div>
        <div class="col-4 tw-right-side">
            <div id="layout-widgets" class="mt-3">
                <?php echo StatusServersWidget::widget(); ?>
            </div>
        </div>
    </div>
</div>
<?php $this->endContent(); ?>