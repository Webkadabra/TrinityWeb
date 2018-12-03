<?php

/**
 * Podium Module
 * Yii 2 Forum Module
 */

use core\modules\forum\widgets\Readers;
use yii\helpers\Html;
use yii\helpers\Url;

?>
<div class="card">
    <div class="card-header" role="tab">
        <h4 class="card-title mb-0">
            <a href="<?= Url::to(['forum/forum', 'cid' => $model->category_id, 'id' => $model->id, 'slug' => $model->slug]) ?>"><?= Html::encode($model->name) ?></a>
        </h4>
<?php if (!empty($model->sub)): ?>
        <small class="text-muted"><?= Html::encode($model->sub) ?></small>
<?php endif; ?>
    </div>
    <div class="card-body px-0 pt-0 pb-0 table-responsive">
        <?= $this->render('/elements/forum/_threads', ['forum' => $model->id, 'category' => $model->category_id, 'slug' => $model->slug, 'filters' => $filters]) ?>
    </div>
</div>

<div class="card mt-4">
    <div class="card-body small">
        <?= $this->render('/elements/forum/_icons') ?>
        <?= Readers::widget(['what' => 'forum']) ?>
    </div>
</div>
