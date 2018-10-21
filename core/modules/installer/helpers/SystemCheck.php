<?php

namespace core\modules\installer\helpers;

use Yii;
use yii\helpers\Html;

/**
 * SelfTest is a helper class which checks all dependencies of the application.
 */
class SystemCheck
{
    /**
     * Get Results of the Application SystemCheck.
     *
     * Fields
     *  - title
     *  - state (OK, WARNING or ERROR)
     *  - hint
     *
     * @return array
     */
    public static function getResults()
    {
        /**
         * ['title']
         * ['state']    = OK, WARNING, ERROR
         * ['hint']
         */
        $checks = [];

        // Checks PHP Version
        $title = 'PHP - Version - ' . PHP_VERSION;

        if (version_compare(PHP_VERSION, '7.1.0', '>=')) {
            $checks[] = [
                'title' => $title,
                'state' => 'OK'
            ];
        } elseif (version_compare(PHP_VERSION, '7.1.0', '<')) {
            $checks[] = [
                'title' => $title,
                'state' => 'ERROR',
                'hint'  => 'Minimum 7.1'
            ];
        }

        // PDO extension
        $title = 'PDO extension';
        if (extension_loaded('pdo')) {
            $checks[] = [
                'title' => $title,
                'state' => 'OK'
            ];
        } else {
            $checks[] = [
                'title' => $title,
                'state' => 'ERROR',
                'hint'  => 'Install PDO Extension'
            ];
        }

        // PDO MySQL extension
        $title = 'PDO MySQL extension';
        if (extension_loaded('pdo_mysql')) {
            $checks[] = [
                'title' => $title,
                'state' => 'OK'
            ];
        } else {
            $checks[] = [
                'title' => $title,
                'state' => 'ERROR',
                'hint'  => 'Required by database'
            ];
        }

        // COM extension
        $title = 'COM extension';
        if (extension_loaded('com_dotnet') || strtoupper(substr(PHP_OS, 0, 3)) !== 'WIN') {
            $checks[] = [
                'title' => $title,
                'state' => 'OK'
            ];
        } else {
            $checks[] = [
                'title' => $title,
                'state' => 'ERROR',
                'hint'  => 'Install COM extension'
            ];
        }

        // Checks GD Extension
        $title = 'PHP - GD Extension';
        if (function_exists('gd_info')) {
            $checks[] = [
                'title' => $title,
                'state' => 'OK'
            ];
        } else {
            $checks[] = [
                'title' => $title,
                'state' => 'ERROR',
                'hint'  => 'Install GD Extension'
            ];
        }

        // PHP SMTP
        $title = 'PHP Mail SMTP';
        if (strlen(ini_get('SMTP')) > 0) {
            $checks[] = [
                'title' => $title,
                'state' => 'OK'
            ];
        } else {
            $checks[] = [
                'title' => $title,
                'state' => 'WARNING',
                'hint'  => 'SMTP is required to send mails'
            ];
        }
        
        // Check Runtime Directory
        $title = 'Permissions - Runtime';
        if (is_writable(Yii::$app->runtimePath)) {
            $checks[] = [
                'title' => $title,
                'state' => 'OK'
            ];
        } else {
            $checks[] = [
                'title' => $title,
                'state' => 'ERROR',
                'hint'  => 'Make ' . Yii::$app->runtimePath . ' writable'
            ];
        }

        return $checks;
    }
}