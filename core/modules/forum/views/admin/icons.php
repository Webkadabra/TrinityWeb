<?php

use core\modules\forum\models\db\IconsActiveRecord;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('common', 'Иконки');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="characters-index">

    <h1><?php echo Html::encode($this->title); ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php echo Html::a(Yii::t('common', 'Добавить иконку'), ['icon-create'], ['class' => 'btn btn-success']); ?>
    </p>

    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel'  => $searchModel,
        'tableOptions' => ['class' => 'table-dark table table-hover'],
        'columns'      => [
            'id',
            [
                'label'  => Yii::t('common','отображение'),
                'format' => 'html',
                'value'  => function($model) {
                    if($model->icon_type === IconsActiveRecord::TYPE_FONT) {
                        return '<i class="' . $model->icon_string . '" style="font-size: 48px;"></i>';
                    }
  
                        return '<img style="max-width: 48px;" src="' . $model->buildImageUrl() . '"/>';
                },
            ],
            'icon',
            'icon_string',
            [
                'attribute' => 'icon_type',
                'value'     => function ($model) {
                    return IconsActiveRecord::getTypes()[$model->icon_type];
                },
                'filter' => IconsActiveRecord::getTypes()
            ],

            [
                'class'      => 'yii\grid\ActionColumn',
                'template'   => '{update} {delete}',
                'urlCreator' => function (string $action, $model, $key, $index, yii\grid\ActionColumn $el) {
                    return Url::to(['icon-' . $action, 'id' => $model->id]);
                },
            ],
        ],
    ]); ?>
</div>
