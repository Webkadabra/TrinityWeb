<?php

use core\modules\forum\models\User;
use yii\helpers\Url;

$podiumUser = User::findMe();
$messageCount = $podiumUser->getNewMessagesCount();
$subscriptionCount = $podiumUser->getSubscriptionsCount();

?>
<ul class="nav navbar-nav">
    <li role="presentation" class="<?php echo $active === 'profile' ? 'active ' : ''; ?>nav-item"><a href="<?php echo Url::to(['profile/index']); ?>" class="nav-link"><?php echo Yii::t('podium/view', 'My Profile'); ?></a></li>
    <li role="presentation" class="<?php echo $active === 'details' ? 'active ' : ''; ?>nav-item"><a href="<?php echo Url::to(['profile/details']); ?>" class="nav-link"><?php echo Yii::t('podium/view', 'Account Details'); ?></a></li>
    <li role="presentation" class="<?php echo $active === 'forum' ? 'active ' : ''; ?>nav-item"><a href="<?php echo Url::to(['profile/forum']); ?>" class="nav-link"><?php echo Yii::t('podium/view', 'Forum Details'); ?></a></li>
    <li role="presentation" class="<?php echo $active === 'messages' ? 'active ' : ''; ?>nav-item"><a href="<?php echo Url::to(['messages/inbox']); ?>" class="nav-link"><?php if ($messageCount): ?><span class="badge float-right"><?php echo $messageCount; ?></span><?php endif; ?><?php echo Yii::t('podium/view', 'Messages'); ?></a></li>
    <li role="presentation" class="<?php echo $active === 'subscriptions' ? 'active ' : ''; ?>nav-item"><a href="<?php echo Url::to(['profile/subscriptions']); ?>" class="nav-link"><?php if ($subscriptionCount): ?><span class="badge float-right"><?php echo $subscriptionCount; ?></span><?php endif; ?><?php echo Yii::t('podium/view', 'Subscriptions'); ?></a></li>
</ul>
