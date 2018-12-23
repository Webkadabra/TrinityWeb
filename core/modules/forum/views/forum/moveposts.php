<?php

/**
 * Podium Module
 * Yii 2 Forum Module
 */

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\widgets\Pjax;

$this->title = Yii::t('podium/view', 'Move Posts');
$this->params['breadcrumbs'][] = ['label' => Yii::t('podium/view', 'Main Forum'), 'url' => ['forum/index']];
$this->params['breadcrumbs'][] = ['label' => $model->forum->category->name, 'url' => ['forum/category', 'id' => $model->forum->category->id, 'slug' => $model->forum->category->slug]];
$this->params['breadcrumbs'][] = ['label' => $model->forum->name, 'url' => ['forum/forum', 'cid' => $model->forum->category->id, 'id' => $model->forum->id, 'slug' => $model->forum->slug]];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['forum/thread', 'cid' => $model->forum->category->id, 'fid' => $model->forum->id, 'id' => $model->id, 'slug' => $model->slug]];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-warning">
            <div class="panel-heading">
                <strong><?php echo Yii::t('podium/view', 'Select posts to move'); ?></strong>:
            </div>
        </div>
    </div>
</div><br>

<?php echo Html::beginForm(); ?>
<?php Pjax::begin(); ?>
<?php echo ListView::widget([
    'dataProvider'     => $dataProvider,
    'itemView'         => '/elements/forum/_post_select',
    'summary'          => '',
    'emptyText'        => Yii::t('podium/view', 'No posts have been added yet.'),
    'emptyTextOptions' => ['tag' => 'h3', 'class' => 'text-muted'],
    'pager'            => ['options' => ['class' => 'pagination float-right']]
]);  ?>
<?php Pjax::end(); ?>
    <br>
    <div class="row">
        <div class="col-sm-10 col-sm-offset-2">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <?php echo Html::label(Yii::t('podium/view', 'Select a thread for this posts to be moved to'), 'newthread'); ?>
                                <p>* <?php echo Yii::t('podium/view', 'Forums you can moderate are marked with asterisk.'); ?></p>
                                <?php echo Html::dropDownList('newthread', null, $list, ['id' => 'newthread', 'class' => 'form-control', 'options' => $options, 'encode' => false]); ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <?php echo Html::label(Yii::t('podium/view', 'Name of the new thread'), 'newname'); ?>
                                <?php echo Html::textInput('newname', null, ['id' => 'newname', 'class' => 'form-control']); ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <?php echo Html::label(Yii::t('podium/view', 'Parent forum of the new thread'), 'newforum'); ?>
                                <p>* <?php echo Yii::t('podium/view', 'Forums you can moderate are marked with asterisk.'); ?></p>
                                <?php echo Html::dropDownList('newforum', null, $listforum, ['id' => 'newforum', 'class' => 'form-control', 'encode' => false]); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel-footer">
                    <div class="row">
                        <div class="col-sm-12">
                            <?php echo Html::submitButton('<span class="glyphicon glyphicon-ok-sign"></span> ' . Yii::t('podium/view', 'Move Posts'), ['class' => 'btn btn-block btn-primary', 'name' => 'save-button']); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><br>
<?php echo Html::endForm();
