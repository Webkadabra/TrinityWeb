<?php

/* @var $searchModel SearchForm */
/* @var $counter integer */
/* @var $searchResult array */

use frontend\modules\armory\models\SearchForm;
use yii\bootstrap\ActiveForm;
use yii\data\Pagination;
use yii\helpers\Html;
use yii\widgets\LinkPager;

if($counter) {
    $pages = new Pagination([
        'totalCount'      => $counter,
        'defaultPageSize' => Yii::$app->settings->get(Yii::$app->settings::APP_MODULE_ARMORY_PER_PAGE)
    ]);
}

?>
<?php $form = ActiveForm::begin([
        'id'     => 'armory-form',
        'method' => 'get',
        'action' => ['/armory']
    ]); ?>
    <div class="row justify-content-center">
        <div class="col-sm-12 col-md-12 col-lg-4 col-xl-5">
            <?php echo $form->field($searchModel, 'server')
                ->dropDownList($searchModel->getServers(),[
                    'prompt' => Yii::t('core','Select server'),
                    'name'   => 'server',
                ])->label(false); ?>
        </div>
        <div class="col-sm-7 col-md-7 col-lg-4 col-xl-3">
            <?php echo $form->field($searchModel, 'query')->textInput([
                'placeholder' => Yii::t('core','Search...')
            ])->label(false); ?>
        </div>
        <div class="col-4 col-sm-5 col-md-5 col-lg-3 col-xl-2">
            <div class="form-group">
                <?php echo Html::submitButton(Yii::t('core', 'Submit'), [
                    'class' => 'btn btn-primary w-100'
                ]); ?>
            </div>
        </div>
    </div>
    <?php
    if($searchResult) {
        foreach($searchResult as $character) {
    ?>
        <div class="row justify-content-center">
            <div class="col-6 col-sm-4 col-md-4 flat character_armory_find_result">
                <?php echo Yii::$app->armoryHelper::buildTagRaceImage($character['race'],$character['gender']);?>
                <?php echo Yii::$app->armoryHelper::buildTagClassImage($character['class']);?>
                <?php
                    //TODO
                    /*echo Html::a($character['name'],
                        [
                            'character/index','server' => Yii::$app->DBHelper->getServerName(),
                            'character' => $character['name']
                        ],['target' => '_blank']
                    );*/
                    echo $character['name'];
                ?>
            </div>
        </div>
        <?php
        }?>
        <div class="row justify-content-center">
            <?php
                echo LinkPager::widget([
                    'pagination' => $pages,
                ]);
            ?>
        </div>
    <?php
    }
    ?>
<?php ActiveForm::end(); ?>