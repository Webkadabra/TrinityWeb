<?php

use yii\helpers\Html;

/* @var $this yii\web\View */

$this->title = Yii::t('common', 'Редактирование иконки: ' . $model->id, [
    'nameAttribute' => '' . $model->id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('common', 'Иконки'), 'url' => ['icons']];
$this->params['breadcrumbs'][] = Yii::t('common', 'Редактирование');
?>
<div class="icons-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('icon_form', [
        'model' => $model,
    ]) ?>

</div>
