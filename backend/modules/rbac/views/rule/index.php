<?php

use core\widgets\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;

/* @var $this  yii\web\View */
/* @var $model backend\modules\rbac\models\BizRule */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel backend\modules\rbac\models\searchs\BizRule */

$this->title = Yii::t('rbac-admin', 'Rules');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="role-index">

    <h1><?php echo Html::encode($this->title); ?></h1>

    <p>
        <?php echo Html::a(Yii::t('rbac-admin', 'Create Rule'), ['create'], ['class' => 'btn btn-success']); ?>
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
            ['class' => 'yii\grid\ActionColumn',],
        ],
    ]);
    ?>

</div>
