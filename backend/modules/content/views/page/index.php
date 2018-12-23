<?php

use core\grid\EnumColumn;
use core\models\Page;
use core\widgets\GridView;
use yii\helpers\Html;

/**
 * @var $this         yii\web\View
 * @var $searchModel  \backend\models\search\PageSearch
 * @var $dataProvider yii\data\ActiveDataProvider
 * @var $model        core\models\Page
 */

$this->title = Yii::t('backend', 'Pages');

$this->params['breadcrumbs'][] = $this->title;

?>

<div class="box box-success collapsed-box">
    <div class="box-header with-border">
        <h3 class="box-title"><?php echo Yii::t('backend', 'Create {modelClass}', ['modelClass' => 'Page']); ?></h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
        </div>
    </div>
    <div class="box-body">
        <?php echo $this->render('_form', [
            'model' => $model,
        ]); ?>
    </div>
</div>

<?php echo GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel'  => $searchModel,
    'options'      => [
        'class' => 'grid-view table-responsive',
    ],
    'tableOptions' => ['class' => 'table table-dark table-hover'],
    'columns'      => [
        [
            'attribute' => 'id',
        ],
        [
            'attribute' => 'slug',
        ],
        [
            'label' => 'title',
            'value' => function ($model) {
                return Html::a($model->title, ['update', 'id' => $model->id]);
            },
            'format' => 'raw',
        ],
        [
            'class'     => EnumColumn::class,
            'attribute' => 'status',
            'enum'      => Page::statuses(),
            'filter'    => Page::statuses(),
        ],
        [
            'class'    => 'yii\grid\ActionColumn',
            'template' => '{delete}',
        ],
    ],
]); ?>
