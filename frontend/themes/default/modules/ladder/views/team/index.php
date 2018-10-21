<?php
use yii\helpers\Html;
?>
<div id="ladder-team-container">
    <table class="flat table table-dark">
        <thead class="ladder-team-header">
        <tr>
            <th scope="col">
                <?=Yii::t('ladder','Character')?>
            </th>
            <th scope="col" class="d-none d-lg-table-cell">
                <?=Yii::t('ladder','Race/Class')?>
            </th>
            <th scope="col">
                <?=Yii::t('ladder','Wins')?>
            </th>
            <th scope="col">
                <?=Yii::t('ladder','Loses')?>
            </th>
            <th scope="col">
                <?=Yii::t('ladder','Rating')?>
            </th>
            <th scope="col" class="d-none d-sm-table-cell">
                <?=Yii::t('ladder','MMR')?>
            </th>
        </tr>
        </thead>
        <tbody class="ladder-team-members">
        <?php
        foreach($data['members'] as $item) {
            ?>
            <tr class="ladder-team-member">
                <td>
                    <?php
                    //TODO
                    //if(Yii::$app->settings->get(Yii::$app->settings::MODULE_ARMORY_STATUS) ===  Yii::$app->TW::ENABLED) {
                    if(false) {
                        echo Html::a($item['relationCharacter']['name'],[
                            '/armory/character/index',
                            'server' => Yii::$app->DBHelper->getServerNameById(Yii::$app->DBHelper->getServerFromGet()),
                            'character' => $item['character']['name']
                        ]);
                    } else {
                        echo ("<span>" . $item['character']['name'] . "</span>");
                    }
                    ?>
                </td>
                <td class="d-none d-lg-table-cell">
                    <?php
                    //echo Yii::$app->TrinityWeb->buildTagRaceImage($item['character']['race'],$item['relationCharacter']['gender']);
                    //echo Yii::$app->TW->buildTagClassImage($item['character']['class']);
                    ?>
                </td>
                <td>
                    <span><?=$item['seasonWins']?></span>
                </td>
                <td>
                    <span><?=($item['seasonGames'] - $item['seasonWins'])?></span>
                </td>
                <td>
                    <?=$item['personalRating']?>
                </td>
                <td class="d-none d-sm-table-cell">
                    <?php
                    $mmr = 1500;
                    if($item['character']) {
                        $character = $item['character'];
                        if($character['arenaStats']) {
                            foreach($character['arenaStats'] as $mmr_info) {
                                //type 2v2 to slot = 0 for 2v2
                                if($data['type'] === 2 && $mmr_info['slot'] === 0) {
                                    $mmr = $mmr_info['matchMakerRating'];
                                    //type 3v3 to slot = 1 for 3v3
                                } elseif($data['type'] === 3 && $mmr_info['slot'] === 1) {
                                    $mmr = $mmr_info['matchMakerRating'];
                                    //type 5v5 to slot = 2 for 5v5
                                } elseif($data['type'] === 5 && $mmr_info['slot'] === 2) {
                                    $mmr = $mmr_info['matchMakerRating'];
                                }
                            }
                        }
                    }
                    echo $mmr;
                    ?>
                </td>
            </tr>
            <?php
        }
        ?>
        </tbody>
    </table>
</div>