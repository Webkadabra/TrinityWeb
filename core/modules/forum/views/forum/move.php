<?php

/**
 * Podium Module
 * Yii 2 Forum Module
 */

use yii\helpers\Html;

$this->title = Yii::t('podium/view', 'Move Thread');
$this->params['breadcrumbs'][] = ['label' => Yii::t('podium/view', 'Main Forum'), 'url' => ['forum/index']];
$this->params['breadcrumbs'][] = ['label' => $model->forum->category->name, 'url' => ['forum/category', 'id' => $model->forum->category->id, 'slug' => $model->forum->category->slug]];
$this->params['breadcrumbs'][] = ['label' => $model->forum->name, 'url' => ['forum/forum', 'cid' => $model->forum->category->id, 'id' => $model->forum->id, 'slug' => $model->forum->slug]];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['forum/thread', 'cid' => $model->forum->category->id, 'fid' => $model->forum->id, 'id' => $model->id, 'slug' => $model->slug]];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="row">
    <div class="col-sm-8 mx-auto">
        <div class="card">
            <?php echo Html::beginForm(); ?>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <?php echo Html::label(Yii::t('podium/view', 'Select a forum for this thread to be moved to'), 'forum'); ?>
                            <p>* <?php echo Yii::t('podium/view', 'Forums you can moderate are marked with asterisk.'); ?></p>
                            <?php echo Html::dropDownList('forum', null, $list, ['id' => 'forum', 'class' => 'form-control', 'options' => $options, 'encode' => false]); ?>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-sm-12">
                            <?php echo Html::submitButton('<span class="glyphicon glyphicon-ok-sign"></span> ' . Yii::t('podium/view', 'Move Thread'), ['class' => 'btn btn-block btn-primary', 'name' => 'save-button']); ?>
                        </div>
                    </div>
                </div>
            <?php echo Html::endForm(); ?>
        </div>
    </div>
</div><br>
