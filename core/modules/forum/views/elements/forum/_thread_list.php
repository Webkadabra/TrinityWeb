<?php

/**
 * Podium Module
 * Yii 2 Forum Module
 */

use core\modules\forum\models\Thread;
use yii\widgets\ListView;

$filtersOn = false;
if (!isset($filters)) {
    $filters = null;
}
if (!empty($filters)) {
    foreach ($filters as $filter) {
        if ($filter) {
            $filtersOn = true;
            break;
        }
    }
}
?>
<?php echo ListView::widget([
    'dataProvider'     => (new Thread())->search($forum, $filters),
    'itemView'         => '/elements/forum/_thread',
    'summary'          => '',
    'emptyText'        => $filtersOn
                            ? Yii::t('podium/view', 'No threads matching the filters can be found.')
                            : Yii::t('podium/view', 'No threads have been added yet.'),
    'emptyTextOptions' => ['tag' => 'td', 'class' => 'text-muted', 'colspan' => 4],
    'options'          => ['tag' => 'tbody'],
    'itemOptions'      => ['tag' => 'tr', 'class' => 'podium-thread-line d-flex']
]);
