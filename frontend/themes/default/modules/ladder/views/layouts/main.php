<?php
/* @var $this \yii\web\View */
/* @var $content string */

use core\widgets\Breadcrumbs;
use core\widgets\Alert;

use frontend\modules\ladder\assets\LadderAssets;
use frontend\widgets\StatusServers\StatusServersWidget;

LadderAssets::register($this);
$this->title = Yii::t('ladder','Ladder');
$this->beginContent('@frontend/views/layouts/base.php')
?>
<div class="fix-header">
    <div class="container">

        <?= Alert::widget() ?>

        <div class="row row-overflow">
            <div class="col-md-8 col-h-full" id="left-side">

                <?php echo Breadcrumbs::widget([
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ]) ?>

                <?php echo $content ?>

            </div>
            <div class="col-md-4 col-h-full" id="right-side">
                <div class="right-container col-h-full">
                    <?php echo StatusServersWidget::widget() ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->endContent() ?>