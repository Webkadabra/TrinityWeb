<?php
/** @var $checks \core\modules\installer\helpers\SystemCheck */
/** @var $hasError \core\modules\installer\helpers\SystemCheck */

use yii\bootstrap\ActiveForm;

?>
<div class="card card-default">
    <div class="card-header">
        <h2 class="text-center">
            <?=Yii::t('installer','System Check')?>
        </h2>
    </div>
    <div class="card-body">
            <p><?=Yii::t('installer','In the following overview, you can see, if all the requirements are ready.')?></p>
            <hr/>
            <div class="prerequisites-list">
                <ul>
                    <?php foreach ($checks as $check) {
                        ?>
                        <li>
                            <?php if ($check['state'] == 'OK') { ?>
                                <i class="fa fa-check-circle check-ok animated bounceIn"></i>
                            <?php
                            } elseif ($check['state'] == 'WARNING') { ?>
                                <i class="fa fa-exclamation-triangle check-warning animated swing"></i>
                            <?php
                            } elseif ($check['state'] == 'ERROR') { ?>
                                <i class="fa fa-minus-circle check-error animated wobble"></i>
                            <?php
                            } ?>

                            <strong><?= $check['title']; ?></strong>

                            <?php if (isset($check['hint'])) { ?>
                                <span>(Hint: <?= $check['hint']; ?>)</span>
                            <?php } ?>
                        </li>
                    <?php
                    } ?>
                </ul>
            </div>

            <?php if (!$hasError) { ?>
                <div class="alert alert-success">
                    <?=Yii::t('installer','Congratulations! Everything is ok and ready to start over!')?>
                </div>
            <?php
            } ?>
            <hr/>

            <div class="row no-gutters justify-content-between">
                <div class="col-auto">
                    <?= \yii\helpers\Html::a('<i class="fas fa-redo"></i> ' . Yii::t('installer','Check again'), ['prerequisites'], ['class' => 'btn btn-info']) ?>
                </div>
                <div class="col-auto">
                    <?php if (!$hasError) { ?>
                        <?php
                        $form = ActiveForm::begin(['id' => 'submit-install-step', 'options' => [
                            'class' => 'd-inline-block'
                        ]]);
                        ?>
                        <?= \yii\helpers\Html::submitButton(Yii::t('installer','Next') . ' <i class="fa fa-arrow-circle-right"></i>', ['class' => 'btn btn-primary']) ?>
                        <?php
                        $form::end();
                        ?>
                    <?php } ?>
                </div>
            </div>
    </div>
</div>