<?php

/**
 * Podium Module
 * Yii 2 Forum Module
 */

use core\modules\forum\Podium;
use yii\helpers\Url;

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('podium/view', 'Main Forum'), 'url' => ['forum/index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<?php if (!Podium::getInstance()->user->isGuest): ?>
<div class="row">
    <div class="col-sm-3 col-sm-offset-9">
        <div class="form-group">
            <a href="<?php echo Url::to(['forum/unread-posts']); ?>" class="btn btn-info btn-xs btn-block"><span class="glyphicon glyphicon-flash"></span> <?php echo Yii::t('podium/view', 'Unread posts'); ?></a>
        </div>
    </div>
</div>
<?php endif; ?>

<div class="row">
    <div class="col-sm-12" id="forum-content">
        <div class="card-group" role="tablist" aria-multiselectable="true">
            <?php echo $this->render('/elements/forum/_section', ['model' => $model]); ?>
        </div>
    </div>
</div>
<?php echo $this->render('/elements/main/_members');
