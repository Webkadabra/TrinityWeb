<?php

/**
 * Podium Module
 * Yii 2 Forum Module
 */

use yii\widgets\Pjax;

?>
<?php Pjax::begin() ?>
<table class="table table-hover mb-0">
    <?= $this->render('/elements/forum/_thread_header', ['forum' => $forum, 'category' => $category, 'slug' => $slug, 'filters' => $filters]) ?>
    <?= $this->render('/elements/forum/_thread_list', ['forum' => $forum, 'filters' => $filters]) ?>
</table>
<?php Pjax::end() ?>
