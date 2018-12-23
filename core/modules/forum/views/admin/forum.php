<?php

use core\modules\forum\models\db\IconsActiveRecord;
use kartik\tree\TreeView;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = Yii::t('view', 'List Forums');
Yii::$app->params['breadcrumbs'][] = ['label' => Yii::t('view', 'Administration Dashboard'), 'url' => ['admin/index']];
Yii::$app->params['breadcrumbs'][] = ['label' => Yii::t('view', 'Categories List'), 'url' => ['admin/categories']];
Yii::$app->params['breadcrumbs'][] = $this->title;

$this->registerJs("$('[data-toggle=\"popover\"]').popover();");

?>
<?php echo $this->render('/elements/admin/_navbar', ['active' => 'categories']); ?>
<br>
<div class="row">
    <div class="col-md-3 col-sm-4">
        <ul class="nav navbar-nav">
            <li role="presentation" class="nav-item">
                <a href="<?php echo Url::to(['admin/categories']); ?>" class="nav-link">
                    <span class="glyphicon glyphicon-list"></span> <?php echo Yii::t('view', 'Categories List'); ?>
                </a>
            </li>
            <?php foreach ($categories as $category): ?>
                <li role="presentation" class="nav-item">
                    <a href="<?php echo Url::to(['admin/new-forum', 'cid' => $category->id]); ?>" class="nav-link">
                        <span class="glyphicon glyphicon-chevron-right"></span> <?php echo Html::encode($category->name); ?>
                    </a>
                </li>
            <?php endforeach; ?>
            <li role="presentation" class="nav-item">
                <a href="<?php echo Url::to(['admin/new-category']); ?>" class="nav-link">
                    <span class="glyphicon glyphicon-plus"></span> <?php echo Yii::t('view', 'Create new category'); ?>
                </a>
            </li>
        </ul>
    </div>
    <div class="col-md-6 col-sm-8">
        <div class="card">
            <div class="card-body" id="widget-tree-forum">
                <?php
                echo TreeView::widget([
                    'query'          => $query->addOrderBy('root, lft'),
                    'headingOptions' => ['label' => Yii::t('app','Список форумов')],
                    'mainTemplate'   => '<div>{wrapper}</div><div>{detail}</div>',
                    'treeOptions'    => [
                        'style' => 'height: 200px;',
                    ],
                    'iconEditSettings'=> [
                        'show'     => 'list',
                        'type'     => TreeView::ICON_RAW,
                        'listData' => IconsActiveRecord::getDataArray(),
                    ],
                    'fontAwesome'   => true,
                    'isAdmin'       => true,
                    'displayValue'  => 1,
                    'softDelete'    => true,
                    'cacheSettings' => [
                        'enableCache' => true
                    ],
                    'nodeAddlViews' => [
                        2 => '@core/modules/forum/views/admin/_forum_form',
                    ],
                    'nodeActions' => [
                        'manage' => Url::to(['forum-node/manage']),
                        'save'   => Url::to(['forum-node/save']),
                    ],
                ]);
                ?>
            </div>
        </div>
    </div>
</div>