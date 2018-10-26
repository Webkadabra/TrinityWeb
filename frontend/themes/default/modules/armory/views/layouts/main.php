<?php

use core\widgets\Breadcrumbs;
use core\widgets\Alert;

use frontend\modules\armory\assets\ArmoryAsset;

/* @var $content string */
/* @var $this \yii\web\View */

$this->title = Yii::t('armory','Armory');
$this->beginContent('@frontend/views/layouts/base.php');

ArmoryAsset::register($this);

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
            <?= $content?>
        </div>
    </div>
</div>
<?php $this->endContent() ?>
