<?php

namespace core\modules\i18n\bundles;

use yii\web\AssetBundle;

/**
 * Contains javascript files necessary for translating javascript messages on the client side (`lajax.t()` calls).
 *
 * @author Lajos Molnár <lajax.m@gmail.com>
 *
 * @since 1.0
 */
class TranslationPluginAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@core/modules/i18n/assets';

    /**
     * @inheritdoc
     */
    public $js = [
        'javascripts/md5.js',
        'javascripts/lajax.js',
    ];

    /**
     * @inheritdoc
     */
    public $depends = [
        'core\modules\i18n\bundles\LanguageItemPluginAsset',
    ];
}
