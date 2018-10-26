<?php

use core\widgets\Breadcrumbs;
use core\widgets\DbCarousel;
use core\widgets\Alert;

use frontend\modules\ladder\assets\LadderAssets;

use frontend\widgets\Marquee\MarqueeWidget;
use frontend\widgets\StatusServers\StatusServersWidget;

/* @var $content string */
/* @var $this \yii\web\View */

$this->title = Yii::t('ladder','Ladder');
$this->beginContent('@frontend/views/layouts/base.php');

LadderAssets::register($this);

?>
<div id="carousel-container" class="fix-header">
    <?php echo DbCarousel::widget([
        'key'=>'index',
        'assetManager' => Yii::$app->getAssetManager(),
        'options' => [
            'class' => 'slide carousel-with-indicator',
        ]
    ]) ?>
</div>
<div class="container mih-100">
    <div class="row mih-100">
        <div class="col-12">
            <?= Alert::widget() ?>
        </div>
        <div class="col-8 tw-left-side">
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
            <?= MarqueeWidget::widget()?>
            <?= $content?>
        </div>
        <div class="col-4">
            <div id="layout-widgets" class="mt-3">
                <?php echo StatusServersWidget::widget() ?>
            </div>
        </div>
    </div>
</div>
<?php $this->endContent() ?>
