<?php

/* @var $status_list  */
/* @var $this \yii\web\View */
/* @var $shared_online int */
?>
<div class="card widget" id="widget-status_servers">
    <div class="card-header text-center pt-2 pb-1">
        <h5>
            <?=Yii::t('frontend','Total online: {count}', [
                'count' => $shared_online,
            ])?>
        </h5>
    </div>
    <div class="card-body p-0">
        <?php
        foreach($status_list as $server_name => $status) {
            ?>
            <div class="server row no-gutters align-items-center h-100">
                <div class="col-auto">
                    <span class="server_name"><?=\yii\helpers\StringHelper::truncate($status['name'],15,'...')?></span>
                </div>
                <div class="col server-bar px-2">
                    <div class="server-caption">
                        <div class="text-left">
                            <?php
                            if($status['status'] == Yii::$app->TrinityWeb::ONLINE) {
                                echo $status['count'];
                            } else {
                                echo Yii::t('frontend','offline');
                            }
                            ?>
                        </div>
                    </div>
                    <div class="server-bar-container">
                        <?php
                        $percent = 100;
                        if($status['status'] == Yii::$app->TrinityWeb::ONLINE) {
                            //TODO magic number (1000)
                            $percent = $status['count'] / (1000 / 100);
                        }
                        ?>
                        <div class="bar bar-<?=($status['status'] == Yii::$app->TrinityWeb::ONLINE ? Yii::$app->TrinityWeb::ONLINE : Yii::$app->TrinityWeb::OFFLINE) ?>" style="width:<?=$percent?>%"></div>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
</div>