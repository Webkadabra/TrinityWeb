<?php
/**
 * @var $this yii\web\View
 * @var $model core\models\Article
 */
use yii\helpers\Html;
?>
<div class="article-item">
        <div class="article-preview position-relative">
            <?php if ($model->thumbnail_path): ?>
                <?php echo Html::img(
                    Yii::$app->glide->createSignedUrl([
                        'glide/index',
                        'path' => $model->thumbnail_path
                    ], true),
                    ['class' => 'article-thumb w-100']
                ); ?>
                <h2 class="article-title">
                    <?php echo Html::a(Yii::$app->i18nHelper::getLangAttributeValue($model,'title'), ['article/view', 'slug'=>$model->slug]); ?>
                </h2>
            <?php endif; ?>
        </div>
        <div class="article-content">
            <?php if (!$model->thumbnail_path): ?>
                <h2 class="article-title">
                    <?php echo Html::a(Yii::$app->i18nHelper::getLangAttributeValue($model,'title'), ['article/view', 'slug'=>$model->slug]); ?>
                </h2>
            <?php endif; ?>
            <div class="article-announce">
                <?php echo Yii::$app->i18nHelper::getLangAttributeValue($model,'announce');?>
            </div>
            <div class="article-meta">
                <span class="article-date tltp" data-toggle="tooltip" data-placement="bottom" title="<?php echo Yii::t('frontend','Дата публикации');?>">
                    <i class="fa fa-clock"></i>&nbsp;
                    <?php echo Yii::$app->formatter->asDatetime($model->published_at); ?>
                </span>
                <span class="article-category ml-3">
                    <i class="fa fa-bookmark tw-aqua"></i>&nbsp;
                    <?php echo Html::a(
                        $model->category->title,
                        ['index', 'ArticleSearch[category_id]' => $model->category_id]
                    );?>
                </span>
            </div>
        </div>
</div>
