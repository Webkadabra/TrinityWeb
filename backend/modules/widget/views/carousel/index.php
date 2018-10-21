<?php

use core\grid\EnumColumn;
use core\models\WidgetCarousel;
use core\widgets\GridView;
use yii\helpers\Html;

/**
 * @var $this                  yii\web\View
 * @var $searchModel           \backend\modules\widget\models\search\CarouselSearch
 * @var $dataProvider          yii\data\ActiveDataProvider
 * @var $model                 core\models\WidgetCarousel
 */

$this->title = Yii::t('backend', 'Widget Carousels');

$this->params['breadcrumbs'][] = $this->title;

?>

<div class="box box-success collapsed-box">
    <div class="box-header with-border">
        <h3 class="box-title"><?php echo Yii::t('backend', 'Create {modelClass}', ['modelClass' => 'Widget Carousel']) ?></h3>
    </div>
    <div class="box-body">
        <?php echo $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>
</div>

<?php echo GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'options' => [
        'class' => 'grid-view table-responsive',
    ],
    'tableOptions' => ['class' => 'table table-dark table-hover'],
    'columns' => [
        [
            'attribute' => 'id',
            'options' => ['style' => 'width: 5%'],
        ],
        [
            'attribute' => 'key',
            'value' => function ($model) {
                return Html::a($model->key, ['update', 'id' => $model->id]);
            },
            'format' => 'raw',
        ],
        [
            'class' => EnumColumn::class,
            'attribute' => 'status',
            'options' => ['style' => 'width: 10%'],
            'enum' => WidgetCarousel::statuses(),
            'filter' => WidgetCarousel::statuses(),
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'options' => ['style' => 'width: 5%'],
            'template' => '{update} {delete}',
        ],
    ],
]); ?>
