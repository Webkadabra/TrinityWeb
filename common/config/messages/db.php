<?php

return \yii\helpers\ArrayHelper::merge(
    require(__DIR__ . '/_base.php'),
    [
        'format' => 'db',
        'db' => 'db',
        'sourceMessageTable' => '{{%language_source}}',
        'messageTable' => '{{%language_translate}}',
    ]
);
