<?php

use core\modules\forum\models\Thread;
use yii\widgets\ListView;

?>
<?= ListView::widget([
    'dataProvider'     => (new Thread())->searchByUser($id),
    'itemView'         => '/elements/forum/_thread',
    'summary'          => '',
    'emptyText'        => Yii::t('podium/view', 'No threads have been added yet.'),
    'emptyTextOptions' => ['tag' => 'td', 'class' => 'text-muted', 'colspan' => 4],
    'options'          => ['tag' => 'tbody'],
    'itemOptions'      => ['tag' => 'tr', 'class' => 'podium-thread-line']
]);
