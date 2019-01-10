<?php

/* @var $content string */
/* @var $this \yii\web\View */

use frontend\modules\profile\assets\ProfileAssets;
use yii\bootstrap\Nav;
use yii\helpers\Html;
use frontend\assets\DefaultAsset;

ProfileAssets::register($this);

$bundle = \Yii::$app->assetManager->getBundle(DefaultAsset::class);
?>
<div class="row" id="profile-head">
    <div class="col-12">
        <div class="card">
            <div class="card-body p-0 position-relative">
                <?=Html::img(
                    $bundle->baseUrl . '/images/profile_bg.jpg',
                    [
                        'class' => 'w-100',
                    ]
                )?>
                <div class="profile-footer">
                    <nav class="navbar navbar-dark default-tw-nav">
                        <div class="navbar-collapse offset-md-3">
                            <?php echo Nav::widget([
                                'options'         => ['class' => 'nav'],
                                'items'           => [
                                    [
                                        'label' => Yii::t('frontend', 'Button 1'),
                                    ],
                                    [
                                        'label' => Yii::t('frontend', 'Button 2'),
                                    ],
                                ]
                            ]); ?>
                        </div>
                    </nav>
                </div>
            </div>
        </div>

    </div>
</div>
