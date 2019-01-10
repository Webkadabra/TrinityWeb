<?php

use yii\helpers\Html;
use yii\helpers\Url;

?>
<div class="card">
    <div class="card-header" role="tab">
        <h4 class="card-title mb-0">
            <a href="<?php echo Url::to(['forum/category', 'id' => $model->id, 'slug' => $model->slug]); ?>"><?php echo Html::encode($model->name); ?></a>
        </h4>
        <?php
        if($model->description) {
            ?>
            <small class="text-muted"><?=$model->description?></small>
            <?php
        }?>
    </div>
    <div class="card-body px-0 pt-0 pb-0" role="tabpanel">
        <?php echo $this->render('/elements/forum/_forums', ['category' => $model->id]); ?>
    </div>
</div>
