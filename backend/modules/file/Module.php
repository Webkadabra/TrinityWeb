<?php

namespace backend\modules\file;

use yii\base\BootstrapInterface;
use yii\web\Application;
use yii\web\GroupUrlRule;

/**
 * file module definition class
 */
class Module extends \yii\base\Module implements BootstrapInterface
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'backend\modules\file\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }

    public function bootstrap($app)
    {
        if ($app instanceof Application) {
            $this->addUrlManagerRules($app);
        }
    }

    protected function addUrlManagerRules($app)
    {
        $app->urlManager->addRules([new GroupUrlRule([
            'prefix' => $this->id,
            'rules'  => require __DIR__ . '/url-rules.php',
        ])], true);
    }
}
