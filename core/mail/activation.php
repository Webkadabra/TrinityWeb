<?php
/**
 * @var $this \yii\web\View
 * @var $url \core\models\User
 */
?>
<?php echo Yii::t('frontend', 'Your activation link: {url}', ['url' => Yii::$app->formatter->asUrl($url)]); ?>
