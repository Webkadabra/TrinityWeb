<?php

use yii\helpers\Html;
use yii\helpers\Url;

?>
<div class="card">
    <div class="card-header" role="tab">
        <h4 class="card-title mb-0">
            <a href="<?= Url::to(['forum/category', 'id' => $model->id, 'slug' => $model->slug]) ?>"><?= Html::encode($model->name) ?></a>
        </h4>
    </div>
    <div class="card-body table-responsive px-0 pt-0 pb-0" role="tabpanel">
        <?= $this->render('/elements/forum/_forums', ['category' => $model->id]) ?>
    </div>
</div>
