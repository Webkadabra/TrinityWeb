<?php

use core\modules\forum\Podium;
use yii\helpers\Html;
use yii\helpers\Url;

?>
<td class="forum-icon col-4 col-lg-6">
    <a href="<?php echo Url::to(['forum/forum', 'cid' => $model->category_id, 'id' => $model->id, 'slug' => $model->slug]); ?>" class="rf-aqua">
        <?php echo Html::decode($model->name); ?>
    </a>
    <?php if (!empty($model->sub)): ?>
        <div>
            <small class="text-muted"><?php echo Html::encode($model->sub); ?></small>
        </div>
    <?php endif; ?>
    <div class="row child-forums"><?php
        foreach($model->children()->all() as $child) {
            ?>
            <div class="ml-2 col-xs-11 col-md-5 child-forum">
                <a href="<?php echo Url::to(['forum/forum', 'cid' => $child->category_id, 'id' => $child->id, 'slug' => $child->slug]); ?>" class="child-forum-link fz-12">
                    <?php echo Html::encode($child->name); ?>
                </a>
            </div>
            <?php
        }
        ?>
    </div>
</td>
<td class="forum-icon text-right col-2 col-lg-1">
    <?php echo $model->threads; ?>
</td>
<td class="forum-icon text-right col-3 col-lg-2">
    <?php echo $model->posts; ?>
</td>
<td class="col-3">
    <?php
    $latest = $model->findLatestPost();
    ?>
    <?php if (!empty($latest) && !empty($latest->thread)): ?>
        <a href="<?php echo Url::to(['forum/thread', 'cid' => $latest->thread->category_id, 'fid' => $latest->thread->forum_id, 'id' => $latest->thread->id, 'slug' => $latest->thread->slug]); ?>" class="center-block rf-aqua">
            <?php echo Html::encode($latest->thread->name); ?>
        </a>
    <?php endif; ?>
</td>