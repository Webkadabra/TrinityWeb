<?php
namespace core\modules\installer\models\config;

use yii\base\Model;

/**
 * Class AppSettingsForm
 *
 * @var string $app_name
 * @var string $app_announce
 *
 * @package core\modules\installer\models\config
 */
class AppSettingsForm extends Model
{
    public $app_name = 'TrinityWeb';

    public $app_announce = 'Lorem Ipsum is simply dummy text of the printing and typesetting industry';

	public function rules()
	{
            return [
                [['app_name'],'required'],
                [['app_name'],'string'],
                [['app_announce'],'string', 'max' => 75]
            ];
	}

	public function attributeLabels()
	{
            return [
                'app_name'       => \Yii::t('installer','Application name'),
                'app_announce'   => \Yii::t('installer','Application announce'),
            ];
	}
}
