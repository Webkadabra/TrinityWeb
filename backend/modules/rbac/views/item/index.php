<?php

use backend\modules\rbac\components\Configs;
use backend\modules\rbac\components\RouteRule;
use core\widgets\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel backend\modules\rbac\models\searchs\AuthItem */
/* @var $context backend\modules\rbac\components\ItemController */

$context = $this->context;
$labels = $context->labels();
$this->title = Yii::t('rbac-admin', $labels['Items']);
$this->params['breadcrumbs'][] = $this->title;

$rules = array_keys(Configs::authManager()->getRules());
$rules = array_combine($rules, $rules);
unset($rules[RouteRule::RULE_NAME]);
?>
<div class="role-index">
    <h1><?php echo Html::encode($this->title); ?></h1>
    <p>
        <?php echo Html::a(Yii::t('rbac-admin', 'Create ' . $labels['Item']), ['create'], ['class' => 'btn btn-success']); ?>
    </p>
    <?php echo
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel'  => $searchModel,
        'options'      => [
            'class' => 'grid-view table-responsive',
        ],
        'tableOptions' => ['class' => 'table table-dark table-hover'],
        'columns'      => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'name',
                'label'     => Yii::t('rbac-admin', 'Name'),
            ],
            [
                'attribute' => 'ruleName',
                'label'     => Yii::t('rbac-admin', 'Rule Name'),
                'filter'    => $rules
            ],
            [
                'attribute' => 'description',
                'label'     => Yii::t('rbac-admin', 'Description'),
            ],
            ['class' => 'yii\grid\ActionColumn',],
        ],
    ]);
    ?>

</div>
