<?php

use yii\helpers\Html;
use yii\data\Pagination;
use yii\widgets\LinkPager;
use yii\bootstrap\ActiveForm;

use frontend\modules\ladder\models\LadderFormModel;

$pagination = new Pagination(['totalCount' => $data['totalCount']]);
$pagination->setPageSize($data['pageSize']);
?>
    <div id="ladder-container">
        <div class="ladder-search">
            <?php /** @var LadderFormModel $form */
            $form = ActiveForm::begin([
                'id' => 'ladder-form',
                'method' => 'get',
                'action' => ['default/index'],
            ]); ?>
            <div class="row justify-content-center">
                <div class="col-8 col-sm-8 col-md-10 col-lg-10">
                    <div class="row justify-content-center">
                        <div class="col-sm-12 col-md-12 col-lg-4">
                            <?php echo $form->field($searchModel, 'server')->dropDownList($searchModel->getServers(),[
                                'prompt' => Yii::t('cp','Выберите сервер'),
                                'name' => 'server',
                            ])->label(false) ?>
                        </div>
                        <div class="col-sm-12 col-md-7 col-lg-4">
                            <?php echo $form->field($searchModel, 'type')->dropDownList($searchModel->_arr_types,[
                                'prompt' => Yii::t('cp','Выберите тип'),
                                'name' => 'type',
                            ])->label(false) ?>
                        </div>
                        <div class="col-sm-12 col-md-5 col-lg-4">
                            <div class="form-group text-center-sm text-center">
                                <?php echo Html::submitButton(Yii::t('common', 'Отобразить'), ['class' => 'btn btn-primary']) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
        <?php
        if($data['list']) {
            ?>
            <table class="ladder-list flat table table-dark">
                <thead class="ladder-header">
                <tr>
                    <th scope="col" class="d-none d-lg-table-cell">
                        <i class="fas fa-list-ol"></i>
                    </th>
                    <th scope="col">
                        <?=Yii::t('ladder','Team name')?>
                    </th>
                    <th scope="col">
                        <?=Yii::t('ladder','Games')?>
                    </th>
                    <th scope="col">
                        <?=Yii::t('ladder','Wins')?>
                    </th>
                    <th class="d-none d-sm-table-cell" scope="col">
                        <?=Yii::t('ladder','Loses')?>
                    </th>
                    <th scope="col">
                        <?=Yii::t('ladder','Rating')?>
                    </th>
                </tr>
                </thead>
                <tbody class="ladder-list-items">
                <?php
                $_rank = $data['rank_start'];
                foreach($data['list'] as $item) {
                    ?>
                    <tr class="ladder-list-item">
                        <th scope="row" class="d-none d-lg-table-cell">
                            <?=$_rank++?>
                        </th>
                        <td>
                            <?=Html::a($item['name'],[
                                'team/index',
                                'teamId' => $item['arenaTeamId'],
                                'server' => Yii::$app->DBHelper->getServerFromGet()->realm_name,
                            ])?>
                        </td>
                        <td>
                            <?=$item['seasonGames']?>
                        </td>
                        <td>
                            <?=$item['seasonWins']?>
                        </td>
                        <td class="d-none d-sm-table-cell">
                            <?=($item['seasonGames'] - $item['seasonWins'])?>
                        </td>
                        <td>
                            <?=$item['rating']?>
                        </td>
                    </tr>
                    <?php
                }
                ?>
                </tbody>
            </table>
            <?php
        } else {
            ?>
            <h3>
                <?=Yii::t('ladder','На данный момент список пуст.')?>
            </h3>
            <?php
        }
        ?>
    </div>
<?=LinkPager::widget([
    'pagination' => $pagination,
    'pageCssClass' => 'page-item',
    'disabledPageCssClass' => 'disabled page-item',
    'disabledListItemSubTagOptions' => ['class' => 'page-link'],
    'linkOptions' => ['class' => 'page-link']
]);?>