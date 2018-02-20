<?php
use Yii;
use yii\helpers\Html;
?>
<div id="ladder-team-container">
    <div class="flat">
        <div class="ladder-team-header">
            <div class="col-xs-4 col-sm-3 col-md-2">
                <?=Yii::t('ladder','Участник')?>
            </div>
            <div class="col-xs-3 hidden-xs col-sm-3 hidden-sm col-md-2 text-center-xs">
                <?=Yii::t('ladder','Расса/Класс')?>
            </div>
            <div class="col-xs-2 text-center-xs">
                <?=Yii::t('ladder','Побед')?>
            </div>
            <div class="col-xs-3 col-sm-2 text-center-xs">
                <?=Yii::t('ladder','Поражений')?>
            </div>
            <div class="col-xs-3 col-sm-2 text-center-xs">
                <?=Yii::t('ladder','Рейтинг')?>
            </div>
            <div class="col-xs-3 hidden-xs col-sm-2 col-md-1 text-center-xs">
                <?=Yii::t('ladder','ММР')?>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="ladder-team-members">
            <?php
            foreach($data['relationMembers'] as $item) {
            ?>
            <div class="ladder-team-member">
                <div class="col-xs-4 col-sm-3 col-md-2">
                    <?=Html::a($item['relationCharacter']['name'],[
                        '/armory/character/index',
                        'server' => Yii::$app->CharactersDbHelper->getServerNameById(Yii::$app->CharactersDbHelper->getServerFromGet()),
                        'character' => $item['relationCharacter']['name']
                    ])?>
                </div>
                <div class="col-xs-3 hidden-xs col-sm-3 hidden-sm col-md-2 text-center-xs">
                    <?php
                    echo Yii::$app->AppHelper->buildTagRaceImage($item['relationCharacter']['race'],$item['relationCharacter']['gender']);
                    echo Yii::$app->AppHelper->buildTagClassImage($item['relationCharacter']['class']);
                    ?>
                </div>
                <div class="col-xs-2 text-center-xs">
                    <span><?=$item['seasonWins']?></span>
                </div>
                <div class="col-xs-3 col-sm-2 text-center-xs">
                    <span><?=($item['seasonGames'] - $item['seasonWins'])?></span>
                </div>
                <div class="col-xs-3 col-sm-2 text-center-xs">
                    <?=$item['personalRating']?>
                </div>
                <div class="col-xs-3 hidden-xs col-sm-2 col-md-1 text-center-xs">
                    <?php
                    if($item['relationCharacter']) {
                        $character = $item['relationCharacter'];
                        if($character['relationArenaStats']) {
                            foreach($character['relationArenaStats'] as $mmr_info) {
                                if($data['type'] === 2 && $mmr_info['slot'] === 0) {
                                    $mmr = $mmr_info['matchMakerRating'];
                                } elseif($data['type'] === 3 && $mmr_info['slot'] === 1) {
                                    $mmr = $mmr_info['matchMakerRating'];
                                } elseif($data['type'] === 5 && $mmr_info['slot'] === 3) {
                                    $mmr = $mmr_info['matchMakerRating'];
                                } else {
                                    $mmr = 1500;
                                }
                            }
                        }
                    }
                    echo $mmr;
                    ?>
                </div>
                <div class="clearfix"></div>
            </div>
            <?php
            }
            ?>
        </div>
    </div>
</div>