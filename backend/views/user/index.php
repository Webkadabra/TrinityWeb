<?php

use core\grid\EnumColumn;
use core\models\User;
use core\widgets\DateTime\DateTimeWidget;
use core\widgets\GridView;
use yii\helpers\Html;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('backend', 'Users');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel'  => $searchModel,
        'options'      => [
            'class' => 'grid-view table-responsive'
        ],
        'tableOptions' => ['class' => 'table table-dark table-hover'],
        'columns'      => [
            'id',
            'username',
            'email:email',
            [
                'class'     => EnumColumn::class,
                'attribute' => 'status',
                'enum'      => User::statuses(),
                'filter'    => User::statuses()
            ],
            [
                'attribute' => 'created_at',
                'format'    => 'datetime',
                'filter'    => DateTimeWidget::widget([
                    'model'                => $searchModel,
                    'attribute'            => 'created_at',
                    'phpDatetimeFormat'    => 'dd.MM.yyyy',
                    'momentDatetimeFormat' => 'DD.MM.YYYY',
                    'clientEvents'         => [
                        'dp.change' => new JsExpression('(e) => $(e.target).find("input").trigger("change.yiiGridView")')
                    ],
                ])
            ],
            [
                'attribute' => 'logged_at',
                'format'    => 'datetime',
                'filter'    => DateTimeWidget::widget([
                    'model'                => $searchModel,
                    'attribute'            => 'logged_at',
                    'phpDatetimeFormat'    => 'dd.MM.yyyy',
                    'momentDatetimeFormat' => 'DD.MM.YYYY',
                    'clientEvents'         => [
                        'dp.change' => new JsExpression('(e) => $(e.target).find("input").trigger("change.yiiGridView")')
                    ],
                ])
            ],
            'updated_at',
            [
                'class'          => 'yii\grid\ActionColumn',
                'template'       => '{view} {delete}',
                'visibleButtons' => [
                    'view'   => Yii::$app->user->can(Yii::$app->PermissionHelper::ACCESS_BACKEND_TO_VIEW_USER),
                    'delete' => Yii::$app->user->can(Yii::$app->PermissionHelper::ACCESS_BACKEND_TO_REMOVE_USER)
                ]
            ],
        ],
    ]); ?>

</div>
