<?php

namespace backend\widgets;

use Yii;
use yii\base\Widget;

/**
 * Class realmCharts
 * @package backend\components\widget
 */
class realmsChart extends Widget
{

    public $realm_id = null;
    public $title = null;

    public function run()
    {
        $lang_config = [
            "downloadPNG" => Yii::t('charts',"Скачать в PNG"),
            "downloadJPEG" => Yii::t('charts',"Скачать в JPEG"),
            "downloadPDF" => Yii::t('charts',"Скачать в PDF"),
            "downloadSVG" => Yii::t('charts',"Скачать в SVG"),
            "loading" => Yii::t('charts',"Загрузка..."),
            "noData" => Yii::t('charts',"Нет данных"),
            "printChart" => Yii::t('charts',"Распечатать"),
            "resetZoom" => Yii::t('charts',"Сбросить масштаб"),
            "rangeSelectorFrom" => Yii::t('charts',"От"),
            "rangeSelectorTo" => Yii::t('charts',"До"),
            "rangeSelectorZoom" => Yii::t('charts',"Масштаб"),
            "weekdays" => [
                "-1" => "promt",
                "0" => Yii::t('charts',"Воскресенье"),
                "1" => Yii::t('charts',"Понедельник"),
                "2" => Yii::t('charts',"Вторник"),
                "3" => Yii::t('charts',"Среда"),
                "4" => Yii::t('charts',"Четверг"),
                "5" => Yii::t('charts',"Пятница"),
                "6" => Yii::t('charts',"Суббота")
            ],
            "shortMonths" => [
                "-1" => "promt",
                "0" => Yii::t('charts',"Янв."),
                "1" => Yii::t('charts',"Фев."),
                "2" => Yii::t('charts',"Март"),
                "3" => Yii::t('charts',"Апр."),
                "4" => Yii::t('charts',"Май"),
                "5" => Yii::t('charts',"Июн."),
                "6" => Yii::t('charts',"Июл."),
                "7" => Yii::t('charts',"Авг."),
                "8" => Yii::t('charts',"Сен."),
                "9" => Yii::t('charts',"Окт."),
                "10" => Yii::t('charts',"Нбр."),
                "11" => Yii::t('charts',"Дек.")
            ],
            "months" => [
                "-1" => "promt",
                "0" => Yii::t('charts',"Январь"),
                "1" => Yii::t('charts',"Февраль"),
                "2" => Yii::t('charts',"Март"),
                "3" => Yii::t('charts',"Апрель"),
                "4" => Yii::t('charts',"Май"),
                "5" => Yii::t('charts',"Июнь"),
                "6" => Yii::t('charts',"Июль"),
                "7" => Yii::t('charts',"Август"),
                "8" => Yii::t('charts',"Сентябрь"),
                "9" => Yii::t('charts',"Октябрь"),
                "10" => Yii::t('charts',"Ноябрь"),
                "11" => Yii::t('charts',"Декабрь")
            ]
        ];

        return $this->render('realmsChart',[
            'id' => $this->id,
            'lang_config' => $lang_config
        ]);
    }
}
