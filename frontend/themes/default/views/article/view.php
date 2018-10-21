<?php

use yii\helpers\Html;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $model core\models\Article */
$this->title = $model->title;
$this->params['breadcrumbs'][] = $this->title;
$this->registerMetaTag([
    'property' => 'og:title',
    'content' => Html::encode($model->title)
],'og:title');
$this->registerMetaTag([
    'property' => 'og:image',
    'content' => Yii::$app->glide->createSignedUrl(['glide/index','path' => $model->thumbnail_path,'w' => 200], true)
],'og:image');
$this->registerMetaTag([
    'name' => 'description',
    'content' => Html::encode(StringHelper::truncate($model->body, 175, '...', null, true))
],'description');
?>
<div class="content">
    <article class="article-item">
        <h1><?php echo $model->title ?></h1>

        <?php if ($model->thumbnail_path): ?>
            <?php echo Html::img(
                Yii::$app->glide->createSignedUrl([
                    'glide/index',
                    'path' => $model->thumbnail_path,
                    'w' => 200
                ], true),
                ['class' => 'article-thumb img-rounded pull-left']
            ) ?>
        <?php endif; ?>

        <?php echo $model->body ?>

        <?php if (!empty($model->articleAttachments)): ?>
            <h3><?php echo Yii::t('frontend', 'Attachments') ?></h3>
            <ul id="article-attachments">
                <?php foreach ($model->articleAttachments as $attachment): ?>
                    <li>
                        <?php echo Html::a(
                            $attachment->name,
                            ['attachment-download', 'id' => $attachment->id])
                        ?>
                        (<?php echo Yii::$app->formatter->asSize($attachment->size) ?>)
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

    </article>
</div>