<?php

/**
 * Podium Module
 * Yii 2 Forum Module
 */

use core\modules\forum\helpers\Helper;
use core\modules\forum\models\User;
use core\modules\forum\Podium;
use core\modules\forum\widgets\gridview\ActionColumn;
use core\modules\forum\widgets\gridview\GridView;
use core\modules\forum\widgets\Readers;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = Yii::t('podium/view', 'Members List');
$this->params['breadcrumbs'][] = $this->title;

?>
<ul class="nav mr-auto">
    <li role="presentation" class="active nav-item">
        <a href="<?= Url::to(['members/index']) ?>" class="nav-link">
            <span class="glyphicon glyphicon-user"></span>
            <?= Yii::t('podium/view', 'Members List') ?>
        </a>
    </li>
    <li role="presentation" class="nav-item">
        <a href="<?= Url::to(['members/mods']) ?>" class="nav-link">
            <span class="glyphicon glyphicon-scissors"></span>
            <?= Yii::t('podium/view', 'Moderation Team') ?>
        </a>
    </li>
</ul>
<br>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        [
            'attribute' => 'username',
            'label' => Yii::t('podium/view', 'Username'),
            'format' => 'raw',
            'value' => function ($model) {
                return Html::a($model->podiumName, ['members/view', 'id' => $model->id, 'slug' => $model->podiumSlug], ['data-pjax' => '0']);
            },
        ],
        [
            'attribute' => 'role',
            'label' => Yii::t('podium/view', 'Role'),
            'format' => 'raw',
            'filter' => User::getRoles(),
            'value' => function ($model) {
                return Helper::roleLabel($model->role);
            },
        ],
        [
            'attribute' => 'created_at',
            'label' => Yii::t('podium/view', 'Joined'),
            'format' => 'datetime'
        ],
        [
            'attribute' => 'threads_count',
            'label' => Yii::t('podium/view', 'Threads'),
            'value' => function ($model) {
                return $model->threadsCount;
            },
        ],
        [
            'attribute' => 'posts_count',
            'label' => Yii::t('podium/view', 'Posts'),
            'value' => function ($model) {
                return $model->postsCount;
            },
        ],
        [
            'class' => ActionColumn::class,
            'template' => '{view}' . (!Podium::getInstance()->user->isGuest ? ' {pm}' : ''),
            'buttons' => [
                'view' => function($url, $model) {
                    return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', ['members/view', 'id' => $model->id, 'slug' => $model->podiumSlug], ActionColumn::buttonOptions([
                        'title' => Yii::t('podium/view', 'View Member')
                    ]));
                },
                'pm' => function($url, $model) {
                    if ($model->id !== User::loggedId()) {
                        return Html::a('<span class="glyphicon glyphicon-envelope"></span>', ['messages/new', 'user' => $model->id], ActionColumn::buttonOptions([
                            'title' => Yii::t('podium/view', 'Send Message')
                        ]));
                    }
                    return ActionColumn::mutedButton('glyphicon glyphicon-envelope');
                },
            ],
        ]
    ],
]); ?>
<div class="card">
    <div class="card-body small">
        <ul class="list-inline float-right">
            <li class="list-inline-item"><a href="<?= Url::to(['forum/index']) ?>" class="nav-link" data-toggle="tooltip" data-placement="top" title="<?= Yii::t('podium/view', 'Go to the main page') ?>"><span class="glyphicon glyphicon-home"></span></a></li>
            <li class="list-inline-item"><a href="#top" class="nav-link" data-toggle="tooltip" data-placement="top" title="<?= Yii::t('podium/view', 'Go to the top') ?>"><span class="glyphicon glyphicon-arrow-up"></span></a></li>
        </ul>
        <?= Readers::widget(['what' => 'members']) ?>
    </div>
</div>