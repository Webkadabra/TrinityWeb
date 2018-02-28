<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\data\Pagination;
use yii\widgets\LinkPager;
use yii\bootstrap\ActiveForm;

use frontend\modules\store\models\SearchForm;

$this->registerJsFile('https://cdn.cavernoftime.com/api/tooltip.js');

if($counter) {
    $pages = new Pagination(['totalCount' => $counter, 'defaultPageSize' => SearchForm::PAGE_SIZE]);
}
$form = ActiveForm::begin([
    'id' => 'store-form',
    'method' => 'get',
    'action' => $cid = Yii::$app->request->get('cid') ? '/store/' . Yii::$app->request->get('cid') : '/store',
]); ?>
    <div class="row">
        <div class="col-xs-12 col-md-8">
            <?php echo $form->field($searchModel, 'query')->textInput([
                'placeholder' => Yii::t('store','Введите текст для поиска...')
            ])->label(false) ?>
        </div>
        <div class="col-xs-12 col-md-4">
            <?php echo $form->field($searchModel, 'server')->dropDownList($searchModel->getServers(),[
                    'prompt' => Yii::t('cp','Выберите сервер'),
                    'name' => 'server',
                ])->label(false) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-sm-6 col-md-4">
            <div class="row">
                <div class="col-xs-6">
                    <?php echo $form->field($searchModel, 'dCoinsFrom')->textInput([
                        'placeholder' => Yii::t('store','от')
                    ])->label(false) ?>
                </div>
                <div class="col-xs-6">
                    <?php echo $form->field($searchModel, 'dCoinsTo')->textInput([
                        'placeholder' => Yii::t('store','до')
                    ])->label(false) ?>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-4">
            <div class="row">
                <div class="col-xs-6">
                    <?php echo $form->field($searchModel, 'vCoinsFrom')->textInput([
                        'placeholder' => Yii::t('store','от')
                    ])->label(false) ?>
                </div>
                <div class="col-xs-6">
                    <?php echo $form->field($searchModel, 'vCoinsTo')->textInput([
                        'placeholder' => Yii::t('store','до')
                    ])->label(false) ?>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-6 col-md-3">
            <?php echo $form->field($searchModel, 'field_order')->dropDownList($searchModel->getFieldsToSotring(),[
                'placeholder' => Yii::t('store','Сортировка по...')
            ])->label(false) ?>
        </div>
        <div class="col-xs-6 col-md-3">
            <?php echo $form->field($searchModel, 'order')->dropDownList([
                SORT_DESC => Yii::t('common','По убыванию'),
                SORT_ASC => Yii::t('common','По возрастанию'),
            ])->label(false) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-1">
            <div class="form-group text-center-sm text-center-xs">
                <?php echo Html::submitButton(Yii::t('common', 'Поиск'), ['class' => 'btn btn-primary']) ?>
            </div>
        </div>
    </div>
<?php ActiveForm::end(); ?>

<div id="store-list">
    <?php
    if($category_discount_info) {
        ?>
        <h4 class="text-center">
            <?=Yii::t('store','На эту категорию действует скидка в размере {discount}%.<br/>Скидки суммируются!', [
                'discount' => $category_discount_info['value'],
            ])?>
        </h4>
        <?php
    }
    ?>
    <hr/>
    <?php
    if($searchResult) {
        foreach($searchResult as $item) {
            if($item['relationItemInfo']) {
                $data_item = [
                    'item_url' => Yii::$app->AppHelper->buildDBUrl($item['item_id'], Yii::$app->AppHelper::$TYPE_ITEM),
                    'icon_url' => Yii::$app->AppHelper->buildItemIconUrl(null, $item['relationItemInfo']['relationIcon']['icon']),
                    'rel_item' => null,
                ];
            } else {
                $data_item = [
                    'item_url' => 'self',
                    'icon_url' => '',
                    'rel_item' => null,
                ];
            }
        ?>
        <div class="row store-item">
            <div class="col-xs-1 text-center">
                <img src="<?=$data_item['icon_url']?>" class="store-item-icon" />
            </div>
            <div class="col-xs-7">
                <a href="<?=$data_item['item_url']?>" target="_blank">
                    <?=$item['name']?>
                </a>
            </div>
            <div class="text-center rf-studio-gold col-xs-<?=($item['discount'] ? 1 : 2)?>">
                <?=$item['dCoins']?>
            </div>
            <div class="text-center rf-studio-silver col-xs-<?=($item['discount'] ? 1 : 2)?>">
                <?=$item['vCoins']?>
            </div>
            <?php
            if($item['discount']) {
            ?>
                <div class="text-center col-xs-2">
                    -<?=$item['discount']?>%
                </div>
            <?php
            }
            ?>
        </div>
        <?php
        }
        ?>
    <div class="col-xs-push-3 col-xs-6 col-sm-push-4 col-sm-4 col-md-push-5 col-md-4">
    <?php
        echo LinkPager::widget([
            'pagination' => $pages,
        ]);
    ?>
    </div>
    <?php
    }
    ?>
</div>
