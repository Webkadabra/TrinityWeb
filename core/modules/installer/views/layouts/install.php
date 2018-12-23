<?php

use core\assets\TrinityWebAssets;
use core\modules\installer\assets\AppAsset;
use core\modules\installer\helpers\TourHelper;
use yii\bootstrap\Nav;
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */

TrinityWebAssets::register($this);
AppAsset::register($this);

$this->beginPage();
?>
<!DOCTYPE html>
<html lang="<?php echo Yii::$app->language; ?>">
    <head>
        <meta charset="<?php echo Yii::$app->charset; ?>"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php echo Html::csrfMetaTags(); ?>
        <title><?php echo Html::encode(Yii::t('installer','TrinitWeb Installer')); ?></title>
        <?php $this->head(); ?>
    </head>
    <body>
        <?php $this->beginBody(); ?>
        <div id="wrap">
            <div class="row no-gutters align-self-center mih-100">
                <div id="sidebar" class="col-6 col-sm-5 col-md-4 col-lg-3 col-xl-3">
                    <nav>
                        <div class="sidebar-header">
                            <h3>
                                <?php echo Yii::t('installer','Installer Wizard');?>
                            </h3>
                        </div>
                        <?php echo Nav::widget([
                            'options'         => ['class' => 'navbar-nav nav'],
                            'activateParents' => true,
                            'items'           => TourHelper::getItemsTour()
                        ]);?>
                    </nav>
                </div>
                <div class="col" id="content">
                    <button type="button" id="sidebarCollapse">
                        <span></span>
                        <span></span>
                        <span></span>
                    </button>
                    <?php echo $content; ?>
                </div>
            </div>
        </div>
        <?php $this->endBody(); ?>
    </body>
</html>
<?php $this->endPage(); ?>