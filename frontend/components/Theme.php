<?php

namespace frontend\components;

use Yii;
use yii\base\Theme as BaseTheme;
use yii\helpers\ArrayHelper;

class Theme extends BaseTheme {
    /**
     * Theme constructor.
     * @param array $config
     */
    public function __construct($config = [])
    {
        if(Yii::$app->TrinityWeb::isAppInstalled()) {
            $currentTheme = Yii::$app->settings->get(Yii::$app->settings::APP_THEME, Yii::$app->settings::DEFAULT_THEME, false);
        } else {
            $currentTheme = Yii::$app->settings::DEFAULT_THEME;
        }
        $baseConfiguration = [
            'basePath' => "@app/themes/$currentTheme",
            'baseUrl'  => '@web',
            'pathMap'  => [
                '@app/views' => [
                    "@app/themes/$currentTheme/views"
                ],
                '@app/modules' => [
                    "@app/themes/$currentTheme/modules"
                ],
                '@app/widgets' => [
                    "@app/themes/$currentTheme/widgets"
                ]
            ]
        ];

        if($currentTheme !== Yii::$app->settings::DEFAULT_THEME) {
            array_unshift($baseConfiguration['pathMap']['@app/views'], "@app/themes/$currentTheme/views");
            array_unshift($baseConfiguration['pathMap']['@app/modules'], "@app/themes/$currentTheme/modules");
            array_unshift($baseConfiguration['pathMap']['@app/widgets'], "@app/themes/$currentTheme/widgets");
        }

        $config = ArrayHelper::merge($config,$baseConfiguration);

        if (!empty($config)) {
            Yii::configure($this, $config);
        }

        $this->init();
    }

    public static function getCurrentTheme() {
        if(Yii::$app->TrinityWeb::isAppInstalled()) {
            return Yii::$app->settings->get(Yii::$app->settings::APP_THEME, Yii::$app->settings::DEFAULT_THEME, false);
        }
  
            return Yii::$app->settings::DEFAULT_THEME;
    }
}