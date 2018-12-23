<?php

/**
 * @author Lajos Molnár <lajax.m@gmail.com>
 *
 * @since 1.0
 */
use core\modules\i18n\helpers\Language;
use core\modules\i18n\models\Language as Lang;
use core\widgets\GridView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

/* @var $this \yii\web\View */
/* @var $language_id string */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel core\modules\i18n\models\searches\LanguageSourceSearch */
/* @var $searchEmptyCommand string */

$this->title = Yii::t('language', 'Translation into {language_id}', ['language_id' => $language_id]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('language', 'Languages'), 'url' => ['list']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?php echo Html::hiddenInput('language_id', $language_id, ['id' => 'language_id', 'data-url' => Yii::$app->urlManager->createUrl('/translatemanager/language/save')]); ?>
<div id="translates" class="<?php echo $language_id; ?>">
    <?php
    Pjax::begin([
        'id' => 'translates',
    ]);
    $form = ActiveForm::begin([
        'method'                 => 'get',
        'id'                     => 'search-form',
        'enableAjaxValidation'   => false,
        'enableClientValidation' => false,
    ]);
    echo $form->field($searchModel, 'source')->dropDownList(['' => Yii::t('language', 'Original')] + Lang::getLanguageNames(true))->label(Yii::t('language', 'Source language'));
    ActiveForm::end();
    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel'  => $searchModel,
        'tableOptions' => ['class' => 'table table-dark table-hover'],
        'columns'      => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'format'             => 'raw',
                'filter'             => Language::getCategories(),
                'attribute'          => 'category',
                'filterInputOptions' => ['class' => 'form-control', 'id' => 'category'],
            ],
            [
                'format'             => 'raw',
                'attribute'          => 'message',
                'filterInputOptions' => ['class' => 'form-control', 'id' => 'message'],
                'label'              => Yii::t('language', 'Source'),
                'content'            => function ($data) {
                    return Html::textarea('LanguageSource[' . $data->id . ']', $data->message, ['class' => 'form-control source', 'readonly' => 'readonly']);
                },
            ],
            [
                'format'             => 'raw',
                'attribute'          => 'translation',
                'filterInputOptions' => [
                    'class'       => 'form-control',
                    'id'          => 'translation',
                    'placeholder' => $searchEmptyCommand ? Yii::t('language', 'Enter "{command}" to search for empty translations.', ['command' => $searchEmptyCommand]) : '',
                ],
                'label'   => Yii::t('language', 'Translation'),
                'content' => function ($data) {
                    return Html::textarea('LanguageTranslate[' . $data->id . ']', $data->translation, ['class' => 'form-control translation', 'data-id' => $data->id, 'tabindex' => $data->id]);
                },
            ],
            [
                'format'  => 'raw',
                'label'   => Yii::t('language', 'Action'),
                'content' => function ($data) {
                    return Html::button(Yii::t('language', 'Save'), ['type' => 'button', 'data-id' => $data->id, 'class' => 'btn btn-lg btn-success']);
                },
            ],
        ],
    ]);
    Pjax::end();
    ?>

</div>