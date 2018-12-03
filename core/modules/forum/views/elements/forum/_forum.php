<?php

use core\modules\forum\Podium;
use yii\helpers\Html;
use yii\helpers\Url;

?>
<td class="forum-icon">
    <a href="<?= Url::to(['forum/forum', 'cid' => $model->category_id, 'id' => $model->id, 'slug' => $model->slug]) ?>" class="rf-aqua">
        <?= Html::encode($model->name) ?>
    </a>
    <?php if (!empty($model->sub)): ?>
        <div>
            <small class="text-muted"><?= Html::encode($model->sub) ?></small>
        </div>
    <?php endif; ?>
    <div class="row child-forums"><?php
        foreach($model->children()->all() as $child) {
            ?>
            <div class="ml-2 col-xs-11 col-md-5 child-forum">
                <a href="<?= Url::to(['forum/forum', 'cid' => $child->category_id, 'id' => $child->id, 'slug' => $child->slug]) ?>" class="child-forum-link fz-12">
                    <?= Html::encode($child->name) ?>
                </a>
            </div>
            <?php
        }
        ?>
    </div>
</td>
<td class="forum-icon text-right"><?= $model->threads ?></td>
<td class="forum-icon text-right"><?= $model->posts ?></td>
<td>
    <?php
    $latest = $model->findLatestPost();
    ?>
    <?php if (!empty($latest) && !empty($latest->thread)): ?>
        <a href="<?= Url::to(['forum/thread', 'cid' => $latest->thread->category_id, 'fid' => $latest->thread->forum_id, 'id' => $latest->thread->id, 'slug' => $latest->thread->slug]) ?>" class="center-block rf-aqua"><?= Html::encode($latest->thread->name) ?></a>
        <small>
            <?= $latest->author->podiumTag ?>
            <span class="d-none"><?= Podium::getInstance()->formatter->asDatetime($latest->created_at, 'medium') ?></span>
            <span class="d-sm-none d-md-none hidden-lg"><?= Podium::getInstance()->formatter->asDatetime($latest->created_at, 'short') ?></span>
        </small>
    <?php endif; ?>
</td>