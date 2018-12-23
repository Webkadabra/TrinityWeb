<?php

namespace core\modules\i18n\controllers\actions;

use core\modules\i18n\models\ImportForm;
use core\modules\i18n\models\Language;
use core\modules\i18n\services\Generator;
use Yii;
use yii\web\UploadedFile;

/**
 * Class for exporting translations.
 */
class ImportAction extends \yii\base\Action
{
    /**
     * Show import form and import the uploaded file if posted
     *
     * @throws \Exception
     * @return string
     *
     */
    public function run()
    {
        $model = new ImportForm();

        if (Yii::$app->request->isPost) {
            $model->importFile = UploadedFile::getInstance($model, 'importFile');

            if ($model->validate()) {
                try {
                    $result = $model->import();

                    $message = Yii::t('language', 'Successfully imported {fileName}', ['fileName' => $model->importFile->name]);
                    $message .= "<br/>\n";
                    foreach ($result as $type => $typeResult) {
                        $message .= "<br/>\n" . Yii::t('language', '{type}: {new} new, {updated} updated', [
                            'type'    => $type,
                            'new'     => $typeResult['new'],
                            'updated' => $typeResult['updated'],
                        ]);
                    }

                    $languageIds = Language::find()
                        ->select('language_id')
                        ->where(['status' => Language::STATUS_ACTIVE])
                        ->column();

                    foreach ($languageIds as $languageId) {
                        $generator = new Generator($this->controller->module, $languageId);
                        $generator->run();
                    }

                    Yii::$app->getSession()->setFlash('success', $message);
                } catch (\Exception $e) {
                    if (YII_DEBUG) {
                        throw $e;
                    }  
                        Yii::$app->getSession()->setFlash('danger', str_replace("\n", "<br/>\n", $e->getMessage()));
                }
            }
        }

        return $this->controller->render('import', [
            'model' => $model,
        ]);
    }
}
