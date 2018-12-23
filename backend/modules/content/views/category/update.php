<?php

/**
 * @var $this       yii\web\View
 * @var $model      core\models\ArticleCategory
 * @var $categories core\models\ArticleCategory[]
 */

$this->title = Yii::t('backend', 'Update {modelClass}: ', [
        'modelClass' => 'Article Category',
    ]) . ' ' . $model->title;

$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Article Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('backend', 'Update');

?>

<?php echo $this->render('_form', [
    'model'      => $model,
    'categories' => $categories,
]); ?>
