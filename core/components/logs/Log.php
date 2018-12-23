<?php

namespace core\components\logs;

use Yii;
use yii\web\Application;

/**
 * Log helper
 */
class Log
{
    /**
     * Returns ID of user responsible for logged action.
     * @return int|null
     */
    public static function blame()
    {
        if (Yii::$app instanceof Application) {
            return Yii::$app->user->getId();
        }

        return null;
    }

    /**
     * Returns log types.
     * @return array
     */
    public static function getTypes()
    {
        return [
            1 => Yii::t('common', 'error'),
            2 => Yii::t('common', 'warning'),
            4 => Yii::t('common', 'info')
        ];
    }

    /**
     * Calls for error log.
     * @param mixed $msg Message
     * @param string $model Model
     * @param string $category
     */
    public static function error($msg, $model = null, $category = 'application')
    {
        Yii::error([
            'msg'   => $msg,
            'model' => $model,
        ], $category);
    }

    /**
     * Calls for info log.
     * @param mixed $msg Message
     * @param string $model Model
     * @param string $category
     */
    public static function info($msg, $model = null, $category = 'application')
    {
        Yii::info([
            'msg'   => $msg,
            'model' => $model,
        ], $category);
    }

    /**
     * Calls for warning log.
     * @param mixed $msg Message
     * @param string $model Model
     * @param string $category
     */
    public static function warning($msg, $model = null, $category = 'application')
    {
        Yii::warning([
            'msg'   => $msg,
            'model' => $model,
        ], $category);
    }
}