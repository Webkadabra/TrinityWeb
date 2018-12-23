<?php

/**
 * Podium Module
 * Yii 2 Forum Module
 */

use yii\helpers\Url;

?>
<ul class="mr-auto nav">
    <li role="presentation" class="<?php echo $active === 'index' ? 'active ' : ''; ?>nav-item">
        <a href="<?php echo Url::to(['admin/index']); ?>" class="nav-link">
            <span class="glyphicon glyphicon-blackboard"></span>
            <span class="d-none d-sm-none"><?php echo Yii::t('podium/view', 'Dashboard'); ?></span>
        </a>
    </li>
    <li role="presentation" class="<?php echo $active === 'categories' ? 'active ' : ''; ?>nav-item">
        <a href="<?php echo Url::to(['admin/categories']); ?>" class="nav-link">
            <span class="glyphicon glyphicon-bullhorn"></span>
            <span class="d-none d-sm-none"><?php echo Yii::t('podium/view', 'Forums'); ?></span>
        </a>
    </li>
    <li role="presentation" class="<?php echo $active === 'icons' ? 'active ' : ''; ?>nav-item">
        <a href="<?php echo Url::to(['admin/icons']); ?>" class="nav-link">
            <span class="glyphicon glyphicon-bullhorn"></span>
            <span class="d-none d-sm-none"><?php echo Yii::t('podium/view', 'Icons'); ?></span>
        </a>
    </li>
    <li role="presentation" class="<?php echo $active === 'contents' ? 'active ' : ''; ?>nav-item">
        <a href="<?php echo Url::to(['admin/contents']); ?>" class="nav-link">
            <span class="glyphicon glyphicon-text-color"></span>
            <span class="d-none d-sm-none"><?php echo Yii::t('podium/view', 'Contents'); ?></span>
        </a>
    </li>
    <li role="presentation" class="<?php echo $active === 'settings' ? 'active ' : ''; ?>nav-item">
        <a href="<?php echo Url::to(['admin/settings']); ?>" class="nav-link">
            <span class="glyphicon glyphicon-cog"></span>
            <span class="d-none d-sm-none"><?php echo Yii::t('podium/view', 'Settings'); ?></span>
        </a>
    </li>
</ul>
