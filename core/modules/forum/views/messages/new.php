<?php

use core\modules\forum\widgets\editor\EditorBasic;
use kartik\select2\Select2;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;

$this->title = Yii::t('podium/view', 'New Message');
$this->params['breadcrumbs'][] = ['label' => Yii::t('podium/view', 'My Profile'), 'url' => ['profile/index']];
$this->params['breadcrumbs'][] = $this->title;

$this->registerJs("$('[data-toggle=\"tooltip\"]').tooltip();");

?>
<div class="row mt-3">
    <div class="col-12">
        <?php $form = ActiveForm::begin(['id' => 'message-form']); ?>
            <div class="row">
                <div class="col-md-3 text-right"><p class="form-control-static"><?php echo Yii::t('podium/view', 'Send to'); ?></p></div>
                <?php if (!empty($to)): ?>
                    <div class="col-md-9">
                        <p class="form-control-static"><?php echo $to->getPodiumTag(true); ?></p>
                        <?php echo $form->field($model, 'receiversId[]')->hiddenInput(['value' => $model->receiversId[0]])->label(false); ?>
                    </div>
                <?php else: ?>
                    <?php if (!empty($friends)): ?>
                        <div class="col-md-4">
                            <?php echo $form->field($model, 'friendsId[]')->widget(Select2::class, [
                                    'options'       => ['placeholder' => Yii::t('podium/view', 'Select a friend...')],
                                    'theme'         => Select2::THEME_KRAJEE,
                                    'showToggleAll' => false,
                                    'data'          => $friends,
                                    'pluginOptions' => [
                                        'allowClear'   => true,
                                        'multiple'     => true,
                                        'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                                    ],
                                ])->label(false); ?>
                        </div>
                        <div class="col-md-1">
                            <p class="form-control-static"><?php echo Yii::t('podium/view', 'and/or'); ?></p>
                        </div>
                        <div class="col-md-4">
                    <?php else: ?>
                        <div class="col-md-9">
                    <?php endif; ?>
                    <?php echo $form->field($model, 'receiversId[]')->widget(Select2::class, [
                            'options'       => ['placeholder' => Yii::t('podium/view', 'Select a member...')],
                            'theme'         => Select2::THEME_KRAJEE,
                            'showToggleAll' => false,
                            'pluginOptions' => [
                                'allowClear'         => true,
                                'multiple'           => true,
                                'minimumInputLength' => 3,
                                'ajax'               => [
                                    'url'      => Url::to(['members/fieldlist']),
                                    'dataType' => 'json',
                                    'data'     => new JsExpression('function(params) { return {q:params.term}; }')
                                ],
                                'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                            ],
                        ])->label(false); ?>
                    </div>
            <?php endif; ?>
                </div>
                <div class="row">
                    <div class="col-md-3 text-right"><p class="form-control-static"><?php echo Yii::t('podium/view', 'Message Topic'); ?></p></div>
                    <div class="col-md-9">
                        <?php echo $form->field($model, 'topic')->textInput(['placeholder' => Yii::t('podium/view', 'Message Topic')])->label(false); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 text-right"><p class="form-control-static"><?php echo Yii::t('podium/view', 'Message Content'); ?></p></div>
                    <div class="col-md-9">
                        <?php echo $form->field($model, 'content')->label(false)->widget(EditorBasic::class); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-9 col-md-offset-3">
                        <?php echo Html::submitButton('<span class="glyphicon glyphicon-ok-sign"></span> ' . Yii::t('podium/view', 'Send Message'), ['class' => 'btn btn-block btn-primary', 'name' => 'send-button']); ?>
                    </div>
                </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
<br>
