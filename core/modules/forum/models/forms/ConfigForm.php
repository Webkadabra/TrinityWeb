<?php

namespace core\modules\forum\models\forms;

use core\modules\forum\Podium;
use core\modules\forum\PodiumConfig;
use yii\base\Model;
use yii\validators\StringValidator;

/**
 * ConfigForm model
 */
class ConfigForm extends Model
{
    /**
     * @var PodiumConfig Configuration instance.
     */
    public $config;

    /**
     * @var string[] Saved settings.
     */
    public $settings;

    /**
     * @var string[] List of read-only settings.
     */
    public $readonly = ['version'];

    /**
     * Returns the value of saved setting.
     * @param string $name Name of setting.
     * @return string
     */
    public function __get($name)
    {
        return isset($this->settings[$name]) ? $this->settings[$name] : '';
    }

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->config = Podium::getInstance()->podiumConfig;
        $this->settings = $this->config->all;
    }

    /**
     * Updates the value of setting.
     * @param string[] $data
     * @return bool
     */
    public function update($data)
    {
        $validator = new StringValidator();
        $validator->max = 255;

        foreach ($data as $key => $value) {
            if (!in_array($key, $this->readonly, true) && array_key_exists($key, $this->settings)) {
                if (!$validator->validate($value)) {
                    return false;
                }
                if (!$this->config->set($key, $value)) {
                    return false;
                }
            }
        }

        return true;
    }
}
