<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\data\Pagination;
use yii\widgets\LinkPager;
use yii\bootstrap\ActiveForm;

use frontend\modules\store\models\SearchForm;

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

<div class="row">
    <?php
    if($searchResult) {
        foreach($searchResult as $item) {?>
        <div class="row">
            <div class="col-xs-push-3 col-xs-6 col-sm-push-4 col-sm-4 col-md-push-4 col-md-4 flat character_armory_find_result">
                <pre>
                    <?php
                    print_r($item);
                    ?>
                </pre>
            </div>
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
