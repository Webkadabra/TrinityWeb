<?php

/**
 * Podium Module
 * Yii 2 Forum Module
 */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = $model->isNewRecord ? Yii::t('podium/view', 'New Category') : Yii::t('podium/view', 'Edit Category');
$this->params['breadcrumbs'][] = ['label' => Yii::t('podium/view', 'Administration Dashboard'), 'url' => ['admin/index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('podium/view', 'Forums'), 'url' => ['admin/categories']];
$this->params['breadcrumbs'][] = $this->title;

$this->registerJs("$('[data-toggle=\"popover\"]').popover();");

?>
<?php echo $this->render('/elements/admin/_navbar', ['active' => 'categories']); ?>
<br>
<div class="row">
    <div class="col-md-3 col-sm-4">
        <div class="form-group">
            <ul class="nav navbar-nav">
                <li role="presentation" class="nav-item"><a href="<?php echo Url::to(['admin/categories']); ?>" class="nav-link"><span class="glyphicon glyphicon-list"></span> <?php echo Yii::t('podium/view', 'Categories List'); ?></a></li>
<?php foreach ($categories as $category): ?>
                <li role="presentation" class="<?php echo $model->id === $category->id ? 'active ' : ''; ?>nav-item"><a href="<?php echo Url::to(['admin/edit-category', 'id' => $category->id]); ?>" class="nav-link"><span class="glyphicon glyphicon-chevron-right"></span> <?php echo Html::encode($category->name); ?></a></li>
<?php endforeach; ?>
                <li role="presentation" class="<?php echo $model->isNewRecord ? 'active ' : ''; ?>"nav-item><a href="<?php echo Url::to(['admin/new-category']); ?>" class="nav-link"><span class="glyphicon glyphicon-plus"></span> <?php echo Yii::t('podium/view', 'Create new category'); ?></a></li>
            </ul>
        </div>
    </div>
    <div class="col-md-6 col-sm-8">
        <div class="card">
            <?php $form = ActiveForm::begin(['id' => 'edit-category-form']); ?>
                <div class="card-header">
                    <h3 class="panel-title"><?php echo $this->title; ?></h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <?php echo $form->field($model, 'name')->textInput(['autofocus' => true])->label(Yii::t('podium/view', "Category's Name")); ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                            <?php
                            $field = $form->field($model, 'visible', ['options' => [
                                'class' => 'position-relative'
                            ]]);
                            $field->template = '{input} {label}';
                            echo $field->checkbox([], false)->label(Yii::t('podium/view', 'Category visible for guests'),[
                                'class' => 'checkbox-label'
                            ]);
                            ?>
                            <small id="help-visible" class="help-block">
                                <?php echo Yii::t('podium/view', 'You can turn off visibility for each individual forum in the category as well.'); ?>
                            </small>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <?php
                            $field = $form->field($model, 'locked', ['options' => [
                                'class' => 'position-relative'
                            ]]);
                            $field->template = '{input} {label}';
                            echo $field->checkbox([], false)->label(Yii::t('podium/view', 'Category locked for users'),[
                                'class' => 'checkbox-label'
                            ]);
                            ?>
                            <small id="help-visible" class="help-block">
                                <?php echo Yii::t('podium/view', 'Adding posts only for administrators'); ?>
                            </small>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-sm-12">
                            <?php echo $form->field($model, 'keywords')->textInput([
                                'placeholder'    => Yii::t('podium/view', 'Optional keywords'),
                                'data-container' => 'body',
                                'data-toggle'    => 'popover',
                                'data-placement' => 'right',
                                'data-content'   => Yii::t('podium/view', 'Meta keywords (comma separated, leave empty to get global value).'),
                                'data-trigger'   => 'focus'
                            ])->label(Yii::t('podium/view', "Category's Meta Keywords")); ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <?php echo $form->field($model, 'description')->textInput([
                                'placeholder'    => Yii::t('podium/view', 'Optional description'),
                                'data-container' => 'body',
                                'data-toggle'    => 'popover',
                                'data-placement' => 'right',
                                'data-content'   => Yii::t('podium/view', 'Meta description (leave empty to get global value).'),
                                'data-trigger'   => 'focus'
                            ])->label(Yii::t('podium/view', "Category's Meta Description")); ?>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-sm-12">
                            <?php echo Html::submitButton('<span class="glyphicon glyphicon-ok-sign"></span> ' . ($model->isNewRecord ? Yii::t('podium/view', 'Create new category') : Yii::t('podium/view', 'Save Category')), ['class' => 'btn btn-block btn-primary', 'name' => 'save-button']); ?>
                        </div>
                    </div>
                </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div><br>
