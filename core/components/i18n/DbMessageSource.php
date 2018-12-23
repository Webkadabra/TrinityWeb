<?php
namespace core\components\i18n;

use yii\i18n\DbMessageSource as YiiDbMessageSource;

class DbMessageSource extends YiiDbMessageSource {
    public function translate($category, $message, $language)
    {
        return $this->translateMessage($category, $message, $language);
    }
}