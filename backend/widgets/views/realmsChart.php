<?php

use miloschuman\highcharts\Highstock;
use yii\web\JsExpression;

Yii::$app->urlManagerApi->setBaseUrl('/');
$apiUrl = Yii::$app->urlManagerApi->createAbsoluteUrl([
    '/v1/realms/data',
    'access-token' => Yii::$app->user->identity->access_token
]);

$js = <<<MOO
    $(function () {
        var seriesOptions = [];
        $.ajax({
            url: "$apiUrl",
            dataType: "json",
            success: function(data) {
                seriesOptions['values'] = [];
                $.each(data.realms, function(realm_key,realm_data) {
                    var collect_data = [];
                    $.each(realm_data.data, function(data_key,graph_data) {
                        collect_data.push([
                            graph_data.date * 1000,
                            parseInt(graph_data.maxplayers)
                        ]);
                    });
                    seriesOptions['values'].push({
                        name: realm_data.name,
                        data: collect_data
                    });
                });
                realm_f_$id(seriesOptions);
            }
        });
    });
MOO;

$this->registerJs($js);

/**
 * Documentation link
 * @see https://api.highcharts.com/highstock/
 */
echo Highstock::widget([
    'id'      => "realm_$id",
    'scripts' => [
        'themes/dark-unica',
    ],
    'setupOptions' => [
        'lang' => $lang_config
    ],
    'options' => [
        'chart' => [
            'renderTo'        => "realm_$id",
            'backgroundColor' => null,
        ],
        'rangeSelector' => [
            'selected' => 1,
            'buttons'  => [
                [
                    'type' => 'all',
                    'text' => Yii::t('charts','Весь период')
                ]
            ],
            'buttonTheme' => [
                'width'  => 100,
                'height' => 18
            ]
        ],
        'title' => ['text' => Yii::t('charts','График онлайна')],
        'yAxis' => [
            'title' => ['text' => Yii::t('charts','Max players')]
        ],
        'tooltip' => [
            'pointFormat'   => '<span style="color:{series.color}">{series.name}</span>: <b>{point.y}</b>',
            'valueDecimals' => 0
        ],
        'series' => new JsExpression('data.values')
    ],
    'callback' => "realm_f_$id"
]);