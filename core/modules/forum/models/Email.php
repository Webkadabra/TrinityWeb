<?php

namespace core\modules\forum\models;

use core\modules\forum\log\Log;
use core\modules\forum\models\db\EmailActiveRecord;
use Exception;

/**
 * Email model
 */
class Email extends EmailActiveRecord
{
    /**
     * Adds email to queue.
     * @param string $address
     * @param string $subject
     * @param string $content
     * @param int|null $userId
     * @return bool
     */
    public static function queue($address, $subject, $content, $userId = null)
    {
        try {
            $email = new static;
            $email->user_id = $userId;
            $email->email = $address;
            $email->subject = $subject;
            $email->content = $content;
            $email->status = self::STATUS_PENDING;
            $email->attempt = 0;

            return $email->save();
        } catch (Exception $e) {
            Log::error($e->getMessage(), null, __METHOD__);
        }

        return false;
    }
}
