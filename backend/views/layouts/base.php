<?php

use backend\assets\BackendAsset;
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */

BackendAsset::register($this);

?>

<?php $this->beginPage(); ?>
<!DOCTYPE html>
<html lang="<?php echo Yii::$app->language; ?>">
<head>
    <meta charset="<?php echo Yii::$app->charset; ?>">
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <link rel="icon" type="image/png" href="/favicon-32x32.png" sizes="32x32" />
    <link rel="icon" type="image/png" href="/favicon-16x16.png" sizes="16x16" />
    <?php echo Html::csrfMetaTags(); ?>
    <title><?php echo Html::encode($this->title); ?></title>
    <?php $this->head(); ?>

</head>
<body>
    <?php $this->beginBody(); ?>
        <?php echo $content; ?>
    <?php $this->endBody(); ?>
</body>
</html>
<?php $this->endPage(); ?>