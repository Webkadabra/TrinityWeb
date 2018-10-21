<?php
/**
 * @var $this \yii\web\View
 * @var $model \core\models\TimelineEvent
 * @var $dataProvider \yii\data\ActiveDataProvider
 */
$this->title = Yii::t('backend', 'Application timeline');
$this->params['breadcrumbs'][] = $this->title;
$this->registerCssFile('@web/css/components/timeline.css');
$date = null;
$icons = [
    'user'=>'<i class="fa fa-user bg-blue"></i>'
];
?>
<?php \yii\widgets\Pjax::begin() ?>
<div class="row">
    <div class="col-md-12">
        <?php if ($dataProvider->count > 0): ?>
            <ul class="timeline">
                <?php foreach($dataProvider->getModels() as $model): ?>
                    <?php if(!isset($date) || $date != Yii::$app->formatter->asDate($model->created_at, 'd')): ?>
                        <li class="time-label">
                            <span>
                                <?php echo Yii::$app->formatter->asDate($model->created_at, 'd') ?>
                            </span>
                        </li>
                        <?php $date = Yii::$app->formatter->asDate($model->created_at) ?>
                    <?php endif; ?>
                    <li>
                        <?php
                            try {
                                $viewFile = sprintf('%s/%s', $model->category, $model->event);
                                echo $this->render($viewFile, ['model' => $model]);
                            } catch (\yii\base\InvalidArgumentException $e) {
                                echo $this->render('_item', ['model' => $model]);
                            }
                        ?>
                    </li>
                <?php endforeach; ?>
                <li>
                    <i class="fa fa-clock-o"></i>
                </li>
            </ul>
        <?php else: ?>
            <?php echo Yii::t('backend', 'No events found') ?>
        <?php endif; ?>
    </div>
    <div class="col-md-12 text-center">
        <?php echo \yii\widgets\LinkPager::widget([
            'pagination'=>$dataProvider->pagination,
            'options' => ['class' => 'pagination']
        ]) ?>
    </div>
</div>
<?php \yii\widgets\Pjax::end() ?>

