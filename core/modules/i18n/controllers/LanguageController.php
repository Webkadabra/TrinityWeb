<?php

namespace core\modules\i18n\controllers;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\data\ArrayDataProvider;
use yii\filters\AccessControl;
use core\modules\i18n\models\Language;

/**
 * Controller for managing multilinguality.
 *
 * @author Lajos Molnár <lajax.m@gmail.com>
 *
 * @since 1.0
 */
class LanguageController extends Controller
{
    /**
     * @var \core\modules\i18n\Module TranslateManager module
     */
    public $module;

    /**
     * @inheritdoc
     */
    public $defaultAction = 'list';

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['list', 'change-status', 'optimizer', 'scan', 'translate', 'save', 'dialog', 'message', 'view', 'create', 'update', 'delete', 'delete-source', 'import', 'export'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['list', 'change-status', 'optimizer', 'scan', 'translate', 'save', 'dialog', 'message', 'view', 'create', 'update', 'delete', 'delete-source', 'import', 'export'],
                        'roles' => $this->module->roles,
                    ],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'list' => [
                'class' => 'core\modules\i18n\controllers\actions\ListAction',
            ],
            'change-status' => [
                'class' => 'core\modules\i18n\controllers\actions\ChangeStatusAction',
            ],
            'optimizer' => [
                'class' => 'core\modules\i18n\controllers\actions\OptimizerAction',
            ],
            'scan' => [
                'class' => 'core\modules\i18n\controllers\actions\ScanAction',
            ],
            'translate' => [
                'class' => 'core\modules\i18n\controllers\actions\TranslateAction',
            ],
            'save' => [
                'class' => 'core\modules\i18n\controllers\actions\SaveAction',
            ],
            'dialog' => [
                'class' => 'core\modules\i18n\controllers\actions\DialogAction',
            ],
            'message' => [
                'class' => 'core\modules\i18n\controllers\actions\MessageAction',
            ],
            'view' => [
                'class' => 'core\modules\i18n\controllers\actions\ViewAction',
            ],
            'create' => [
                'class' => 'core\modules\i18n\controllers\actions\CreateAction',
            ],
            'update' => [
                'class' => 'core\modules\i18n\controllers\actions\UpdateAction',
            ],
            'delete' => [
                'class' => 'core\modules\i18n\controllers\actions\DeleteAction',
            ],
            'delete-source' => [
                'class' => 'core\modules\i18n\controllers\actions\DeleteSourceAction',
            ],
            'import' => [
                'class' => 'core\modules\i18n\controllers\actions\ImportAction',
            ],
            'export' => [
                'class' => 'core\modules\i18n\controllers\actions\ExportAction',
            ],
        ];
    }

    /**
     * Finds the Language model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param string $id
     *
     * @return Language the loaded model
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function findModel($id)
    {
        if (($model = Language::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Returns an ArrayDataProvider consisting of language elements.
     *
     * @param array $languageSources
     *
     * @return ArrayDataProvider
     */
    public function createLanguageSourceDataProvider($languageSources)
    {
        $data = [];
        foreach ($languageSources as $category => $messages) {
            foreach ($messages as $message => $boolean) {
                $data[] = [
                    'category' => $category,
                    'message' => $message,
                ];
            }
        }

        return new ArrayDataProvider([
            'allModels' => $data,
            'pagination' => false,
        ]);
    }
}
