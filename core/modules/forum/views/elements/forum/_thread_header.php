<?php

/**
 * Podium Module
 * Yii 2 Forum Module
 */

use core\modules\forum\Podium;
use yii\helpers\Url;

?>
<?php if (isset($category, $forum, $slug)): ?>
<tr>
    <td colspan="4" class="small">
        <ul class="list-inline">
            <li class="text-muted list-inline-item">
                <?= Yii::t('podium/view', 'Show only') ?>
            </li class="list-inline-item">
<?php if (!Podium::getInstance()->user->isGuest): ?>
            <li class="list-inline-item">
                <a href="<?= Url::to(['forum/forum', 'cid' => $category, 'id' => $forum, 'slug' => $slug, 'toggle' => 'new']) ?>" class="btn btn-success btn-xs <?= !empty($filters['new']) && $filters['new'] ? 'active' : '' ?>">
                    <span class="glyphicon glyphicon-leaf"></span>
                    <span class="d-none d-sm-none"><?= Yii::t('podium/view', 'New Posts') ?></span>
                    <span class="d-none d-md-none d-lg-none"><?= Yii::t('podium/view', 'New') ?></span>
                </a>
            </li>
            <li class="list-inline-item">
                <a href="<?= Url::to(['forum/forum', 'cid' => $category, 'id' => $forum, 'slug' => $slug, 'toggle' => 'edit']) ?>" class="btn btn-warning btn-xs <?= !empty($filters['edit']) && $filters['edit'] ? 'active' : '' ?>">
                    <span class="glyphicon glyphicon-comment"></span>
                    <span class="d-none d-sm-none"><?= Yii::t('podium/view', 'Edited Posts') ?></span>
                    <span class="d-none d-md-none d-lg-none"><?= Yii::t('podium/view', 'Edited') ?></span>
                </a>
            </li>
<?php endif; ?>
            <li class="list-inline-item">
                <a href="<?= Url::to(['forum/forum', 'cid' => $category, 'id' => $forum, 'slug' => $slug, 'toggle' => 'hot']) ?>" class="btn btn-default btn-xs <?= !empty($filters['hot']) && $filters['hot'] ? 'active' : '' ?>">
                    <span class="glyphicon glyphicon-fire"></span>
                    <span class="d-none d-sm-none"><?= Yii::t('podium/view', 'Hot Threads') ?></span>
                    <span class="d-none d-md-none d-lg-none"><?= Yii::t('podium/view', 'Hot') ?></span>
                </a>
            </li>
            <li class="list-inline-item">
                <a href="<?= Url::to(['forum/forum', 'cid' => $category, 'id' => $forum, 'slug' => $slug, 'toggle' => 'pin']) ?>" class="btn btn-default btn-xs <?= !empty($filters['pin']) && $filters['pin'] ? 'active' : '' ?>">
                    <span class="glyphicon glyphicon-pushpin"></span>
                    <span class="d-none d-sm-none"> <?= Yii::t('podium/view', 'Pinned Threads') ?></span>
                    <span class="d-none d-md-none d-lg-none"> <?= Yii::t('podium/view', 'Pinned') ?></span>
                </a>
            </li>
            <li class="list-inline-item">
                <a href="<?= Url::to(['forum/forum', 'cid' => $category, 'id' => $forum, 'slug' => $slug, 'toggle' => 'lock']) ?>" class="btn btn-default btn-xs <?= !empty($filters['lock']) && $filters['lock'] ? 'active' : '' ?>">
                    <span class="glyphicon glyphicon-lock"></span>
                    <span class="d-none d-sm-none"> <?= Yii::t('podium/view', 'Locked Threads') ?></span>
                    <span class="d-none d-md-none d-lg-none"> <?= Yii::t('podium/view', 'Locked') ?></span>
                </a>
            </li>
            <li class="list-inline-item">
                <a href="<?= Url::to(['forum/forum', 'cid' => $category, 'id' => $forum, 'slug' => $slug, 'toggle' => 'all']) ?>" class="btn btn-info btn-xs">
                    <span class="glyphicon glyphicon-asterisk"></span>
                    <span class="d-none d-sm-none"> <?= Yii::t('podium/view', 'All Threads') ?></span>
                    <span class="d-none d-md-none d-lg-none"> <?= Yii::t('podium/view', 'All') ?></span>
                </a>
            </li>
        </ul>
    </td>
</tr>
<?php endif; ?>
<tr>
    <th class="col-sm-7"><small><?= Yii::t('podium/view', 'Thread') ?></small></th>
    <th class="col-sm-1 text-center"><small><?= Yii::t('podium/view', 'Replies') ?></small></th>
    <th class="col-sm-1 text-center"><small><?= Yii::t('podium/view', 'Views') ?></small></th>
    <th class="col-sm-3"><small><?= Yii::t('podium/view', 'Latest Post') ?></small></th>
</tr>
