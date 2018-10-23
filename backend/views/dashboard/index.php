<?php
use backend\widgets\realmsChart;
?>
<div class="row">
    <div class="col-sm-6 col-md-4 grid-margin">
        <div class="card">
            <div class="card-body">
                <div class="d-flex flex-row align-items-top">
                    <i class="far fa-registered align-self-center text-facebook icon-md"></i>
                    <div class="ml-3">
                        <h6 class="text-facebook"><?=Yii::t('backend','Today {count} accounts registered', ['count' => $registeredAccounts_today_count])?></h6>
                        <p class="mt-1 mb-0 card-description"><?=Yii::t('backend','Total count: {count}', ['count' => $registeredAccounts_total_count])?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-4 grid-margin">
        <div class="card">
            <div class="card-body">
                <div class="d-flex flex-row align-items-top">
                    <i class="fas fa-ban align-self-center text-facebook icon-md"></i>
                    <div class="ml-3">
                        <h6 class="text-facebook"><?=Yii::t('backend','Today {count} account banned', ['count' => $bannedAccounts_today_count])?></h6>
                        <p class="mt-1 mb-0 card-description"><?=Yii::t('backend','Total count: {count}', ['count' => $bannedAccounts_total_count])?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-4 grid-margin">
        <div class="card">
            <div class="card-body">
                <div class="d-flex flex-row align-items-top">
                    <i class="fas fa-user-plus align-self-center text-facebook icon-md"></i>
                    <div class="ml-3">
                        <h6 class="text-facebook"><?=Yii::t('backend','{count} GM accounts', ['count' => $gms_total_count])?></h6>
                        <p class="mt-1 mb-0 card-description"><?=Yii::t('backend','with Global access')?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 grid-margin">
        <div class="card overflow-hidden dashboard-curved-chart">
            <div class="float-chart float-chart-mini px-4 mt-2">
                <?= realmsChart::widget();?>
            </div>
        </div>
    </div>
</div>