<?php

/**
 * Podium Module
 * Yii 2 Forum Module
 */

use core\modules\forum\assets\PodiumAsset;
use core\modules\forum\helpers\Helper;
use yii\helpers\Html;

PodiumAsset::register($this);
$this->beginPage(); ?>
<!DOCTYPE html>
<html lang="<?php echo Yii::$app->language; ?>">
<head>
<meta charset="<?php echo Yii::$app->charset; ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php echo Html::csrfMetaTags(); ?>
<title><?php echo Html::encode(Helper::title($this->title)); ?></title>
<?php $this->head(); ?>
</head>
<body>

<?php $this->beginBody(); ?>
    <div class="container">
        <?php echo $this->render('/elements/main/_breadcrumbs'); ?>
        <?php echo \core\widgets\Alert::widget(); ?>
        <?php echo $content; ?>
    </div>
    <?php echo $this->render('/elements/main/_footer'); ?>
<?php $this->endBody(); ?>

</body>
</html>
<?php $this->endPage(); ?>
