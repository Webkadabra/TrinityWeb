<?php

use yii\helpers\Html;

/* @var $this \yii\web\View view component instance */
/* @var $message \yii\mail\MessageInterface the message bing composed */
/* @var $content string main view render result */
?>
<?php $this->beginPage() ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=<?php echo Yii::$app->charset ?>"/>
    <title><?php echo Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <style>
        body {background-color: #23262D;color:#C5C0C0;}
        .rf-studio-black {color: #333;}
        .rf-studio-white {color: #C5C0C0;}
        .rf-studio-orange {color: #e84d3b;}
        .rf-studio-green {color: #5cb85c;}
        .rf-studio-aqua {color: #36BBA6;}
        .badge {padding: 3px 7px;color: #36BBA6;background-color: #C5C0C0;border-radius: 10px;}
    </style>
</head>
<body>
<?php $this->beginBody() ?>
<?php echo $content ?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
