<?php

use yii\helpers\Url;

?>
<ul class="nav navbar-nav">
    <li role="presentation" class="<?= $active == 'inbox' ? 'active ' : '' ?>nav-item"><a href="<?= Url::to(['messages/inbox']) ?>" class="nav-link"><span class="glyphicon glyphicon-inbox"></span> <?= Yii::t('podium/view', 'Messages Inbox') ?></a></li>
    <li role="presentation" class="<?= $active == 'sent' ? 'active ' : '' ?>nav-item"><a href="<?= Url::to(['messages/sent']) ?>" class="nav-link"><span class="glyphicon glyphicon-upload"></span> <?= Yii::t('podium/view', 'Sent Messages') ?></a></li>
    <li role="presentation" class="<?= $active == 'new' ? 'active ' : '' ?>nav-item"><a href="<?= Url::to(['messages/new']) ?>" class="nav-link"><span class="glyphicon glyphicon-envelope"></span> <?= Yii::t('podium/view', 'New Message') ?></a></li>
<?php if ($active == 'view'): ?>
    <li role="presentation" class="active nav-item"><a href="#" class="nav-link"><span class="glyphicon glyphicon-eye-open"></span> <?= Yii::t('podium/view', 'View Message') ?></a></li>
<?php endif; ?>
</ul>
