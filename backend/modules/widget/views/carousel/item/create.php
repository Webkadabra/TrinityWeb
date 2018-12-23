<?php
/**
 * @var $this     yii\web\View
 * @var $model    core\models\WidgetCarouselItem
 * @var $carousel core\models\WidgetCarousel
 */

$this->title = Yii::t('backend', 'Create {modelClass}', [
    'modelClass' => 'Widget Carousel Item',
]);

$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Widget Carousel Items'), 'url' => ['/widget/carousel/index']];
$this->params['breadcrumbs'][] = ['label' => $carousel->key, 'url' => ['/widget/carousel/update', 'id' => $carousel->id]];
$this->params['breadcrumbs'][] = Yii::t('backend', 'Create');

?>

<?php echo $this->render('_form', [
    'model' => $model,
]); ?>
