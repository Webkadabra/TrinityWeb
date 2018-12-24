<?php

/**
 * Podium Module
 * Yii 2 Forum Module
 */

use core\modules\forum\helpers\Helper;
use core\modules\forum\models\Message;
use core\modules\forum\models\User;
use core\modules\forum\Podium;
use core\modules\forum\widgets\Avatar;
use core\modules\forum\widgets\editor\EditorBasic;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$this->title = Yii::t('podium/view', 'Reply to Message');
$this->params['breadcrumbs'][] = ['label' => Yii::t('podium/view', 'My Profile'), 'url' => ['profile/index']];
$this->params['breadcrumbs'][] = $this->title;

$this->registerJs("$('[data-toggle=\"tooltip\"]').tooltip();");

$loggedId = User::loggedId();

?>
<div class="row">
    <div class="col-md-3 col-sm-4">
        <?php echo $this->render('/elements/profile/_navbar', ['active' => 'messages']); ?>
    </div>
    <div class="col-md-9 col-sm-8">
        <?php echo $this->render('/elements/messages/_navbar', ['active' => 'new']); ?>
        <br>
        <?php $form = ActiveForm::begin(['id' => 'message-form']); ?>
            <div class="row">
                <div class="col-md-3 text-right"><p class="form-control-static"><?php echo Yii::t('podium/view', 'Send to'); ?></p></div>
                <div class="col-md-9"><p class="form-control-static"><?php echo $reply->sender->getPodiumTag(true); ?></p>
                    <?php echo $form->field($model, 'receiversId[]')->hiddenInput(['value' => $model->receiversId[0]])->label(false); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 text-right"><p class="form-control-static"><?php echo Yii::t('podium/view', 'Message Topic'); ?></p></div>
                <div class="col-md-9">
                    <?php echo $form->field($model, 'topic')->textInput(['placeholder' => Yii::t('podium/view', 'Message Topic'), 'autofocus' => true])->label(false); ?>
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
        <br>
        <div <?php echo Helper::replyBgd(); ?>>
            <div class="row">
                <div class="col-sm-2 text-center">
                    <div class="position-sticky sticky-header">
                        <?php echo Avatar::widget(['author' => $reply->sender]); ?>
                    </div>
                </div>
                <div class="col-sm-10">
                    <div class="popover right podium">
                        <div class="arrow"></div>
                        <div class="popover-title">
                            <small class="float-right"><span data-toggle="tooltip" data-placement="top" title="<?php echo Podium::getInstance()->formatter->asDatetime($reply->created_at, 'long'); ?>"><?php echo Podium::getInstance()->formatter->asRelativeTime($reply->created_at); ?></span></small>
                            <?php echo Html::encode($reply->topic); ?>
                        </div>
                        <div class="popover-content">
                            <?php echo $reply->parsedContent; ?>
                        </div>
                    </div>
                </div>
            </div>

<?php $stack = 0; while ($reply->reply && $stack < 4): ?>
<?php if ($reply->reply->sender_id === $loggedId && $reply->reply->sender_status === Message::STATUS_DELETED) { $reply = $reply->reply; continue; } ?>
            <div class="row">
                <div class="col-sm-2 text-center">
                    <div class="position-sticky sticky-header">
                        <?php echo Avatar::widget(['author' => $reply->reply->sender]); ?>
                    </div>
                </div>
                <div class="col-sm-10">
                    <div class="popover right podium">
                        <div class="arrow"></div>
                        <div class="popover-title">
                            <small class="float-right"><span data-toggle="tooltip" data-placement="top" title="<?php echo Podium::getInstance()->formatter->asDatetime($reply->reply->created_at, 'long'); ?>"><?php echo Podium::getInstance()->formatter->asRelativeTime($reply->reply->created_at); ?></span></small>
                            <?php echo Html::encode($reply->reply->topic); ?>
                        </div>
                        <div class="popover-content">
                            <?php echo $reply->reply->parsedContent; ?>
                        </div>
                    </div>
                </div>
            </div>
<?php $reply = $reply->reply; $stack++; endwhile; ?>
        </div>

    </div>
</div><br>
