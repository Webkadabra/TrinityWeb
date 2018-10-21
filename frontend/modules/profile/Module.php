<?php

namespace frontend\modules\profile;

use Yii;
use yii\base\BootstrapInterface;
use yii\web\GroupUrlRule;

class Module extends \yii\base\Module implements BootstrapInterface
{
    /**
     * @var string
     */
    public $controllerNamespace = 'frontend\modules\profile\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
    }

    public function bootstrap($app)
    {
        if ($app instanceof \yii\web\Application) {
            $this->setDefaultSettings($app);
            $this->addUrlManagerRules($app);
        }
    }

    protected function setDefaultSettings($app)
    {
        /* @var \BaseApplication $app */
        if(!$app->settings->get($app->settings::APP_MODULE_LADDER_STATUS))
            $app->settings->set($app->settings::APP_MODULE_LADDER_STATUS,$app->settings::ENABLED);

        if(!$app->settings->get($app->settings::APP_MODULE_LADDER_CACHE_DURATION))
            $app->settings->set($app->settings::APP_MODULE_LADDER_CACHE_DURATION,120);

        if(!$app->settings->get($app->settings::APP_MODULE_LADDER_PER_PAGE))
            $app->settings->set($app->settings::APP_MODULE_LADDER_PER_PAGE,5);
    }

    protected function addUrlManagerRules($app)
    {
        $app->urlManager->addRules([new GroupUrlRule([
            'prefix' => $this->id,
            'rules' => require __DIR__ . '/url-rules.php',
        ])]);
    }
}
