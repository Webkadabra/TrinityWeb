<?php

/**
 * Podium Module
 * Yii 2 Forum Module
 */

use yii\helpers\Html;

$typeName = $type === 'topics' ? Yii::t('podium/view', 'threads') : Yii::t('podium/view', 'posts');

?>
<div class="panel panel-default">
    <div class="panel-heading" role="tab" id="forumSearch">
        <h4 class="panel-title">
<?php if (!empty($query) && !empty($author)): ?>
            <?php echo Yii::t('podium/view', 'Search for {type} with "{query}" by "{author}"', ['query' => Html::encode($query), 'author' => Html::encode($author), 'type' => $typeName]); ?>
<?php elseif (!empty($query) && empty($author)): ?>
            <?php echo Yii::t('podium/view', 'Search for {type} with "{query}"', ['query' => Html::encode($query), 'type' => $typeName]); ?>
<?php elseif (empty($query) && !empty($author)): ?>
            <?php echo Yii::t('podium/view', 'Search for {type} by "{author}"', ['author' => Html::encode($author), 'type' => $typeName]); ?>
<?php else: ?>
            <?php echo Yii::t('podium/view', 'Search for {type}', ['type' => $typeName]); ?>
<?php endif; ?>
        </h4>
    </div>
    <div id="collapseSearch" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="forumSearch">
        <?php echo $this->render('/elements/search/_threads_search_topics', ['dataProvider' => $dataProvider, 'type' => $type]); ?>
    </div>
</div>

<div class="panel panel-default">
    <div class="panel-body small">
        <?php echo $this->render('/elements/forum/_icons'); ?>
    </div>
</div>
