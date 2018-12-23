<?php

/** @var $model \core\modules\installer\models\setup\MultyDatabaseForm */
/** @var $success */
/* @var $this \yii\web\View */
/* @var $errorMsg string */

use core\modules\installer\helpers\DatabaseRender;
use core\modules\installer\models\setup\DatabaseForm;
use unclead\multipleinput\TabularInput;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div id="card-form" class="card card-default">
    <div class="card-header">
        <h2 class="text-center">
            <?php echo Yii::t('installer','{dynamic_name} database configuration!', [
                'dynamic_name' => $model->_name,
            ]);?>
        </h2>
    </div>
    <div class="card-body">

        <p><?php echo Yii::t('installer','Below you have to enter your databases connections details. If you’re not sure about these, please contact your administrator.');?></p>

        <?php
        $form = ActiveForm::begin([
            'id' => 'database-form',
        ]);
        echo TabularInput::widget([
            'models'        => $model->dbs,
            'modelClass'    => DatabaseForm::class,
            'rendererClass' => DatabaseRender::class,
            'min'           => 1,
            'layoutConfig'  => [
                'offsetClass'  => 'col-sm-offset-3',
                'labelClass'   => 'w-100',
                'wrapperClass' => 'w-100',
                'errorClass'   => 'col-sm-offset-3 col-sm-6',
            ],
            'form'    => $form,
            'columns' => [
                [
                    'name'          => 'host',
                    'type'          => 'textInput',
                    'headerOptions' => ['class' => 'col-8'],
                    'title'         => 'Host',
                    'defaultValue'  => '',
                ],
                [
                    'name'          => 'port',
                    'type'          => 'textInput',
                    'headerOptions' => ['class' => 'col-4'],
                    'title'         => 'Port',
                    'defaultValue'  => '',
                ],
                [
                    'name'          => 'database',
                    'type'          => 'textInput',
                    'headerOptions' => ['class' => 'col-4'],
                    'title'         => 'DB Name',
                    'defaultValue'  => ''
                ],
                [
                    'name'          => 'login',
                    'type'          => 'textInput',
                    'headerOptions' => ['class' => 'col-5'],
                    'title'         => 'Login',
                    'defaultValue'  => '',
                ],
                [
                    'name'          => 'password',
                    'type'          => 'passwordInput',
                    'headerOptions' => ['class' => 'col-3'],
                    'title'         => 'Password',
                    'defaultValue'  => '',
                    'options'       => [
                        'class' => 'input-priority'
                    ]
                ]
            ],
        ]);
        ?>
        <hr/>
        <?php if ($success) { ?>
            <div class="alert alert-success">
                <?php echo Yii::t('installer','Yes, database connection works!');?>
            </div>
        <?php } elseif (!empty($errorMsg)) { ?>
            <div class="alert alert-danger">
                <?php
                foreach($errorMsg as $msg) {
                    ?>
                    <strong><?php print_r($msg);?></strong>
                    <?php
                }
                ?>
            </div>
        <?php } ?>
        <div class="text-right">
            <?php echo Html::submitButton(Yii::t('installer','Next'), ['class' => 'btn btn-primary']); ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>