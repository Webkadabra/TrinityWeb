<?php

use core\modules\forum\models\User;
use yii\helpers\Url;

$podiumUser        = User::findMe();
$messageCount      = $podiumUser->getNewMessagesCount();
$subscriptionCount = $podiumUser->getSubscriptionsCount();

?>
<ul class="nav navbar-nav">
    <li role="presentation" class="<?= $active == 'profile' ? 'active ' : '' ?>nav-item"><a href="<?= Url::to(['profile/index']) ?>" class="nav-link"><?= Yii::t('podium/view', 'My Profile') ?></a></li>
    <li role="presentation" class="<?= $active == 'details' ? 'active ' : '' ?>nav-item"><a href="<?= Url::to(['profile/details']) ?>" class="nav-link"><?= Yii::t('podium/view', 'Account Details') ?></a></li>
    <li role="presentation" class="<?= $active == 'forum' ? 'active ' : '' ?>nav-item"><a href="<?= Url::to(['profile/forum']) ?>" class="nav-link"><?= Yii::t('podium/view', 'Forum Details') ?></a></li>
    <li role="presentation" class="<?= $active == 'messages' ? 'active ' : '' ?>nav-item"><a href="<?= Url::to(['messages/inbox']) ?>" class="nav-link"><?php if ($messageCount): ?><span class="badge float-right"><?= $messageCount ?></span><?php endif; ?><?= Yii::t('podium/view', 'Messages') ?></a></li>
    <li role="presentation" class="<?= $active == 'subscriptions' ? 'active ' : '' ?>nav-item"><a href="<?= Url::to(['profile/subscriptions']) ?>" class="nav-link"><?php if ($subscriptionCount): ?><span class="badge float-right"><?= $subscriptionCount ?></span><?php endif; ?><?= Yii::t('podium/view', 'Subscriptions') ?></a></li>
</ul>
