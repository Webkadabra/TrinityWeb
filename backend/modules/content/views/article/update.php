<?php

/**
 * @var $this       yii\web\View
 * @var $model      core\models\Article
 * @var $categories core\models\ArticleCategory[]
 */

$this->title = Yii::t('backend', 'Update {modelClass}: ', [
        'modelClass' => 'Article',
    ]) . ' ' . $model->title;

$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Articles'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('backend', 'Update');

?>

<?php echo $this->render('_form', [
    'model' => $model,
    'categories' => $categories,
]) ?>
