<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/**
 * @var $this  yii\web\View
 * @var $model core\models\FileStorageItem
 */

$this->title = $model->name;

$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'File Storage Items'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<p>
    <?php echo Html::a(Yii::t('backend', 'Delete'), ['delete', 'id' => $model->id], [
        'class' => 'btn btn-danger',
        'data'  => [
            'confirm' => Yii::t('backend', 'Are you sure you want to delete this item?'),
            'method'  => 'post',
        ],
    ]); ?>
</p>

<?php echo DetailView::widget([
    'model'      => $model,
    'options'    => ['class' => 'table table-dark table-hover table-responsive'],
    'attributes' => [
        'id',
        'component',
        'base_url:url',
        'path',
        'type',
        'size',
        'name',
        'upload_ip',
        'created_at:datetime',
    ],
]); ?>
