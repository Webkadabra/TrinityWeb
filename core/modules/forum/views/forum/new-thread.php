<?php

/**
 * Podium Module
 * Yii 2 Forum Module
 */

use core\modules\forum\Podium;
use core\modules\forum\widgets\editor\EditorFull;
use core\modules\forum\widgets\poll\Poll;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Alert;
use yii\helpers\Html;

$this->title = Yii::t('podium/view', 'New Thread');
$this->params['breadcrumbs'][] = ['label' => Yii::t('podium/view', 'Main Forum'), 'url' => ['forum/index']];
$this->params['breadcrumbs'][] = ['label' => $forum->category->name, 'url' => ['forum/category', 'id' => $forum->category->id, 'slug' => $forum->category->slug]];
$this->params['breadcrumbs'][] = ['label' => $forum->name, 'url' => ['forum/forum', 'cid' => $forum->category->id, 'id' => $forum->id, 'slug' => $forum->slug]];
$this->params['breadcrumbs'][] = $this->title;

?>
<?php if ($preview): ?>
<div class="row">
    <div class="col-sm-10 mx-auto">
        <?php echo Alert::widget([
            'body' => '<strong><small>'
                        . Yii::t('podium/view', 'Post Preview')
                        . '</small></strong>:<hr>'
                        . $model->parsedPost
                        . (Podium::getInstance()->podiumConfig->get('forum.allow_polls') ? Poll::preview($model) : null),
            'options' => ['class' => 'alert-info']
        ]); ?>
    </div>
</div>
<?php endif; ?>

<div class="row">
    <div class="col-sm-10 mx-auto">
        <div class="card">
            <?php $form = ActiveForm::begin(['id' => 'new-thread-form']); ?>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <?php echo $form->field($model, 'name')->textInput(['autofocus' => true])->label(Yii::t('podium/view', 'Topic')); ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <?php echo $form->field($model, 'post')->label(false)->widget(EditorFull::class); ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <?php
                            $field = $form->field($model, 'subscribe', ['options' => [
                                'class' => 'position-relative'
                            ]]);
                            $field->template = '{input} {label}';
                            echo $field->checkbox([], false)->label('subscribe',[
                                'class' => 'checkbox-label'
                            ]);
                            ?>
                        </div>
                    </div>
<?php if (Podium::getInstance()->podiumConfig->get('forum.allow_polls')): ?>
                    <div class="row">
                        <div class="col-sm-12">
                            <?php echo Poll::create($form, $model); ?>
                        </div>
                    </div>
<?php endif; ?>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-sm-8">
                            <?php echo Html::submitButton(
                                '<span class="glyphicon glyphicon-ok-sign"></span> ' . Yii::t('podium/view', 'Create new thread'),
                                ['class' => 'btn btn-block btn-primary', 'name' => 'save-button']
                            ); ?>
                        </div>
                        <div class="col-sm-4">
                            <?php echo Html::submitButton(
                                '<span class="glyphicon glyphicon-eye-open"></span> ' . Yii::t('podium/view', 'Preview'),
                                ['class' => 'btn btn-block btn-default', 'name' => 'preview-button']
                            ); ?>
                        </div>
                    </div>
                </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div><br>
