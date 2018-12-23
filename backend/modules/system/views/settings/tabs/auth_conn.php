<?php
/**
 * @var $form \yii\bootstrap\ActiveForm
 * @var $model \backend\modules\system\models\SettingsModel
 * @var $this \yii\web\View
 */

use core\modules\installer\helpers\DatabaseRender;
use unclead\multipleinput\TabularInput;

echo TabularInput::widget([
    'id'            => 'auth_conf',
    'form'          => $form,
    'models'        => $model->auth_dbs,
    'rendererClass' => DatabaseRender::class,
    'min'           => 1,
    'layoutConfig'  => [
        'offsetClass'  => 'col-sm-offset-3',
        'labelClass'   => 'w-100',
        'wrapperClass' => 'w-100',
        'errorClass'   => 'col-sm-offset-3 col-sm-6',
    ],
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
<?php if (!empty($errorMsg)) { ?>
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