<?php
namespace core\components\helpers;

use Yii;
use yii\base\Component;

use core\modules\i18n\models\Language;
use yii\base\ErrorException;

class i18nHelper extends Component
{

    /**
     * get locales
     * @param bool $as_associated
     * @return array|Language|mixed
     */
    public static function getLocales($as_associated = false)
    {
        if($as_associated === true) {
            $langs = Yii::$app->cache->get('core.langs_assoc');
            if($langs === false) {
                $langs = Language::getLanguageNames(true);
                Yii::$app->cache->set('core.langs_assoc',$langs,60*15);
            }
        } else {
            $langs = Yii::$app->cache->get('core.langs');
            if($langs === false) {
                $langs = Language::getLanguages(true,true);
                Yii::$app->cache->set('core.langs',$langs,60*15);
            }
        }
        return $langs;
    }

    public static function getIdentLocales() {
        $langs = Yii::$app->cache->get('core.langs_assoc_ident');
        if($langs === false) {
            foreach (Language::getLanguages(true, true) as $language) {
                $langs[$language['ident']] = $language['name'];
            }
            Yii::$app->cache->set('core.langs_assoc_ident',$langs,60*15);
        }
        return $langs;
    }

    public static function getDefaultLocale() {
        $defaultLocale = Yii::$app->sourceLanguage;
        $languageModel = Language::findOne(['language_id' => $defaultLocale]);
        if($languageModel) {
            return $languageModel->ident;
        }
        throw new ErrorException("Problem with detect default locale - locale {$defaultLocale} not found");
    }

    public static function getLocale($language) {
        return Language::findOne(['language_id' => $language]);
    }

}