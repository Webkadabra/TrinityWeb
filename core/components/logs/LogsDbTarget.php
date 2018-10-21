<?php

namespace core\components\logs;

use Yii;
use yii\helpers\VarDumper;
use yii\log\DbTarget as YiiDbTarget;
use yii\web\Request;

/**
 * Database log target
 * Few extra columns.
 */
class LogsDbTarget extends YiiDbTarget
{


    public function init()
    {
        parent::init();
    }

    /**
     * Stores log messages to DB.
     */
    public function export()
    {
        if ($this->db->getTransaction()) {
            $this->db = clone $this->db;
        }
        $tableName = $this->db->quoteTableName($this->logTable);
        $sql = "INSERT INTO $tableName ([[level]], [[category]], [[log_time]], [[prefix]], [[ip]], [[message]], [[model]], [[user_id]])
                VALUES (:level, :category, :log_time, :prefix, :ip, :message, :model, :user)";
        $command = $this->db->createCommand($sql);
        foreach ($this->messages as $message) {
            list($text, $level, $category, $timestamp) = $message;
            $extracted = [
                'msg'   => '',
                'model' => null,
            ];

            if (is_array($text) && (isset($text['msg']) || isset($text['model']))) {
                if (isset($text['msg'])) {
                    if (!is_string($text['msg'])) {
                        $extracted['msg'] = VarDumper::export($text['msg']);
                    } else {
                        $extracted['msg'] = $text['msg'];
                    }
                }
                if (isset($text['model'])) {
                    $extracted['model'] = $text['model'];
                }
            } elseif (is_string($text)) {
                $extracted['msg'] = $text;
            } else {
                $extracted['msg'] = VarDumper::export($text);
            }

            $request = Yii::$app->getRequest();
            $command->bindValues([
                ':level'    => $level,
                ':category' => $category,
                ':log_time' => $timestamp,
                ':prefix'   => $this->getMessagePrefix($message),
                ':ip'       => $request instanceof Request ? $request->getUserIP() : null,
                ':message'  => $extracted['msg'],
                ':model'    => $extracted['model'],
                ':user'     => Log::blame(),
            ])->execute();
        }
    }
}