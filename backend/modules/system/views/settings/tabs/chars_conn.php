<?php
/**
 * @var $form \yii\bootstrap\ActiveForm
 * @var $model \backend\modules\system\models\SettingsModel
 * @var $this \yii\web\View
 */

use core\modules\installer\helpers\DatabaseRender;

use unclead\multipleinput\TabularInput;

echo TabularInput::widget([
    'id' => 'char_conf',
    'models' => $model->char_dbs,
    'rendererClass' => DatabaseRender::class,
    'min' => 1,
    'layoutConfig' => [
        'offsetClass' => 'col-sm-offset-3',
        'labelClass' => 'w-100',
        'wrapperClass' => 'w-100',
        'errorClass' => 'col-sm-offset-3 col-sm-6',
    ],
    'form' => $form,
    'columns' => [
        [
            'name'  => 'name',
            'type'  => 'dropDownList',
            'headerOptions' => ['class' => 'col-12'],
            'items' => function() {
                $return_data = [];
                Yii::$app->cache->delete('core.helpers.list_servers');
                foreach(Yii::$app->DBHelper->getServers() as $server) {
                    $return_data["char_{$server['auth_id']}_{$server['realm_id']}"] = "{$server['id']} | ". $server['realm_name'] .
                        ' | ' .
                        $server['realm_address'] .
                        ':' .
                        $server['realm_port'] .
                        " - build:{$server['realm_build']}";
                }
                return $return_data;
            },
            'title' => 'Name',
            'defaultValue' => '',
            'options' => [
                'placeholder' => 'Type realmname here...',
            ]
        ],
        [
            'name'  => 'host',
            'type'  => 'textInput',
            'headerOptions' => ['class' => 'col-8'],
            'title' => 'Host',
            'defaultValue' => '',
        ],
        [
            'name'  => 'port',
            'type'  => 'textInput',
            'headerOptions' => ['class' => 'col-4'],
            'title' => 'Port',
            'defaultValue' => '',
        ],
        [
            'name'  => 'database',
            'type'  => 'textInput',
            'headerOptions' => ['class' => 'col-4'],
            'title' => 'DB Name',
            'defaultValue' => ''
        ],
        [
            'name'  => 'login',
            'type'  => 'textInput',
            'headerOptions' => ['class' => 'col-5'],
            'title' => 'Login',
            'defaultValue' => '',
        ],
        [
            'name'  => 'password',
            'type'  => 'passwordInput',
            'headerOptions' => ['class' => 'col-3'],
            'title' => 'Password',
            'defaultValue' => '',
            'options' => [
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
            <strong><?php print_r($msg)?></strong>
            <?php
        }
        ?>
    </div>
<?php } ?>
