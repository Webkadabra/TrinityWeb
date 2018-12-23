<?php

namespace core\modules\i18n\controllers\actions;

use core\modules\i18n\models\LanguageSource;
use core\modules\i18n\models\LanguageTranslate;
use Yii;

/**
 * Class for returning messages in the given language
 *
 * @author Lajos Molnár <lajax.m@gmail.com>
 *
 * @since 1.2
 */
class MessageAction extends \yii\base\Action
{
    /**
     * Returning messages in the given language
     *
     * @return string
     */
    public function run()
    {
        $languageTranslate = LanguageTranslate::findOne([
            'id'       => Yii::$app->request->get('id', 0),
            'language' => Yii::$app->request->get('language_id', ''),
        ]);

        if ($languageTranslate) {
            $translation = $languageTranslate->translation;
        } else {
            $languageSource = LanguageSource::findOne([
                'id' => Yii::$app->request->get('id', 0),
            ]);

            $translation = $languageSource ? $languageSource->message : '';
        }

        return $translation;
    }
}
