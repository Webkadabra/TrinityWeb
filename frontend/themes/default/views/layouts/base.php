<?php

use frontend\components\MenuHelper;
use frontend\widgets\Auth\AuthWidget;
use yii\bootstrap\Modal;
use yii\bootstrap\Nav;
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */

$this->beginContent('@frontend/views/layouts/_clear.php');
?>
<div id="wrap">
    <nav id="header-nav" class="navbar navbar-expand-md navbar-dark fixed-top default-tw-nav">
        <div class="container">
            <?php echo Html::a(Yii::$app->settings->get(Yii::$app->settings::APP_NAME) ? Yii::$app->settings->get(Yii::$app->settings::APP_NAME) : Yii::$app->name,['/main/index'],[
                'class' => 'navbar-brand tw-white'
            ]);?>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#header-menu" aria-controls="header-menu" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="header-menu">
                <?php echo Nav::widget([
                    'options'         => ['class' => 'navbar-nav mr-auto'],
                    'activateParents' => true,
                    'items'           => MenuHelper::get_items_for_left_side_menu()
                ]); ?>
                <?php echo Nav::widget([
                    'options' => ['class' => 'navbar-nav ml-auto'],
                    //'activateParents' => true,
                    //'activateItems' =>  true,
                    'encodeLabels' => false,
                    'items'        => MenuHelper::get_items_for_right_side_menu()
                ]); ?>
            </div>
        </div>
    </nav>
    <?php echo $content; ?>
</div>

<?php
if(Yii::$app->user->isGuest) {
    Modal::begin([
        'id'          => 'modal-auth-login',
        'options'     => ['class' => 'fade'],
        'size'        => Modal::SIZE_DEFAULT . ' modal-dialog-centered',
        'closeButton' => [
            'label' => "&nbsp;",
            'class' => 'close'
        ]
    ]);

    echo AuthWidget::widget(['action' => AuthWidget::AUTH]);

    Modal::end();

    Modal::begin([
        'id'          => 'modal-auth-signup',
        'options'     => ['class' => 'fade'],
        'size'        => Modal::SIZE_DEFAULT . ' modal-dialog-centered',
        'closeButton' => [
            'label' => "&nbsp;",
            'class' => 'close'
        ]
    ]);

    echo AuthWidget::widget(['action' => AuthWidget::SIGNUP]);

    Modal::end();
}
?>
<footer id="footer">
    <div class="container h-100">
        <div class="row align-items-center h-100">
            <div class="col">
                &copy; TrinityWeb 2017 - <?php echo date('Y'); ?>
            </div>
            <div class="col">
            </div>
        </div>
    </div>
</footer>
<?php $this->endContent(); ?>