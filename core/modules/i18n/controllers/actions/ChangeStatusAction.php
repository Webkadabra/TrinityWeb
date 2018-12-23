<?php

namespace core\modules\i18n\controllers\actions;

use core\modules\i18n\models\Language;
use Yii;
use yii\web\Response;

/**
 * Class that modifies the state of a language.
 *
 * @author Lajos Molnár <lajax.m@gmail.com>
 *
 * @since 1.0
 */
class ChangeStatusAction extends \yii\base\Action
{
    /**
     * Modifying the state of language.
     *
     * @return array
     */
    public function run()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $language = Language::findOne(Yii::$app->request->post('language_id', ''));
        if ($language !== null) {
            $language->status = Yii::$app->request->post('status', Language::STATUS_BETA);
            if ($language->validate()) {
                $language->save();
            }
        }

        return $language->getErrors();
    }
}
