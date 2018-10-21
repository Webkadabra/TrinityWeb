<?php
namespace core\modules\installer\models\config;

use Yii;
use yii\base\Model;

/**
 * Class RecaptchaForm
 * Holds the recaptcha settings
 *
 * @package core\modules\installer\models\config
 */
class RecaptchaForm extends Model
{
	public $secret;
	public $siteKey;

	public function rules()
	{
            return [
                [['siteKey', 'secret'], 'string'],
            ];
	}

	public function attributeLabels()
	{
            return [
                'siteKey'   => Yii::t('installer','Site Key (optional)'),
                'secret'    => Yii::t('installer','Secret (optional)'),
            ];
	}
}
