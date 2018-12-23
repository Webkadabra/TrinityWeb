<?php

/**
 * Podium Module
 * Yii 2 Forum Module
 */

use core\widgets\Breadcrumbs;
use yii\helpers\Html;
use yii\helpers\Url;

?>
<div class="row">
    <div class="d-none col-sm-<?php echo isset($this->params['no-search']) && $this->params['no-search'] === true ? '12' : '9'; ?>">
        <?php echo Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]); ?>
    </div>
<?php if (!isset($this->params['no-search']) || $this->params['no-search'] !== true): ?>
    <div class="col-sm-3">
        <?php echo Html::beginForm(['forum/search'], 'get'); ?>
            <div class="form-group">
                <div class="input-group">
                    <?php echo Html::textInput('query', null, ['class' => 'form-control']); ?>
                    <div class="input-group-btn">
                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><span class="glyphicon glyphicon-search"></span></button>
                        <ul class="dropdown-menu dropdown-menu-right" role="menu">
                            <li><a href="<?php echo Url::to(['forum/advanced-search']); ?>"><?php echo Yii::t('podium/view', 'Advanced Search Form'); ?></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        <?php echo Html::endForm(); ?>
    </div>
<?php endif; ?>
</div>
