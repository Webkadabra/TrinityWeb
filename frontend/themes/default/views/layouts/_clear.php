<?php

use frontend\assets\DefaultAsset;
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */

$app_name = Html::encode(Yii::$app->settings->get(Yii::$app->settings::APP_NAME, Yii::$app->settings::DEFAULT_APP_NAME));

$this->title = "$app_name | {$this->title}";

$app_lang = substr(Yii::$app->language,0,2);

$this->beginPage();

DefaultAsset::register($this);

?>
<!DOCTYPE html>
<html lang="<?php echo Yii::$app->language; ?>">
<head>
    <meta charset="<?php echo Yii::$app->charset; ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $this->title; ?></title>
    <?php $this->head(); ?>
    <?php echo Html::csrfMetaTags(); ?>
</head>
<body>
<?php $this->beginBody(); ?>
    <?php echo $content; ?>
<?php $this->endBody(); ?>
</body>
</html>
<?php $this->endPage(); ?>
