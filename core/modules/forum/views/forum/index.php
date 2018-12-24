<?php

/**
 * Podium Module
 * Yii 2 Forum Module
 */

use core\modules\forum\Podium;
use core\modules\forum\widgets\LatestPosts;
use yii\helpers\Url;

$this->title = Yii::t('podium/view', 'Main Forum');
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="row">
    <div class="col-sm-9" id="forum-content">
        <?php echo $this->render('/elements/forum/_sections', ['dataProvider' => $dataProvider]); ?>
    </div>
    <div class="col-sm-3">
        <div id="layout-widgets" class="sticky-header">
            <?php if (!Podium::getInstance()->user->isGuest): ?>
                <a href="<?php echo Url::to(['forum/unread-posts']); ?>" class="btn btn-info btn-xs btn-block">
                    <span class="glyphicon glyphicon-flash"></span> <?php echo Yii::t('podium/view', 'Unread posts'); ?>
                </a>
                <br>
            <?php endif; ?>
            <?php echo LatestPosts::widget(); ?>
        </div>
    </div>
</div>
<?php echo $this->render('/elements/main/_members');
