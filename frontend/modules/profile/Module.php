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
        $this->layout = 'main';
    }

    public function bootstrap($app)
    {
        if ($app instanceof \yii\web\Application) {
            $this->addUrlManagerRules($app);
        }
    }

    protected function addUrlManagerRules($app)
    {
        $app->urlManager->addRules([new GroupUrlRule([
            'prefix' => $this->id,
            'rules'  => require __DIR__ . '/url-rules.php',
        ])]);
    }
}
