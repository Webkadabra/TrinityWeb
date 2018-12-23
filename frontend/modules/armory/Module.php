<?php

namespace frontend\modules\armory;

use Yii;
use yii\base\BootstrapInterface;
use yii\web\GroupUrlRule;

class Module extends \yii\base\Module implements BootstrapInterface
{
    /**
     * @var string
     */
    public $controllerNamespace = 'frontend\modules\armory\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->layout = 'main';
        $this->setAliases(['@armory' => __DIR__]);
    }

    public function bootstrap($app)
    {
        if ($app instanceof \yii\web\Application) {
            $this->setDefaultSettings($app);
            $this->addUrlManagerRules($app);
        }
    }

    public function beforeAction($action) {
        Yii::$app->view->params['breadcrumbs'][] = ['label' => Yii::t('armory','Armory'),'url' => ['/armory/main/index']];
        if(Yii::$app->settings->get(Yii::$app->settings::APP_MODULE_ARMORY_STATUS) !== Yii::$app->settings::ENABLED) {
            return Yii::$app->response->redirect(Yii::$app->homeUrl);
        }

        return parent::beforeAction($action);
    }

    protected function setDefaultSettings($app)
    {
        /* @var \BaseApplication $app */
        if(Yii::$app->TrinityWeb::isAppInstalled()) {
            if (
                !$app->settings->get($app->settings::APP_MODULE_ARMORY_STATUS)
                    ||
                !(
                    $app->settings->get($app->settings::DB_ARMORY_STATUS) !== $app->settings::INSTALLED
                        &&
                    $app->settings->get($app->settings::DB_ARMORY_DATA_STATUS) !== $app->settings::INSTALLED
                )
            ) {
                $app->settings->set($app->settings::APP_MODULE_ARMORY_STATUS, $app->settings::DISABLED);
            }

            if (!$app->settings->get($app->settings::APP_MODULE_ARMORY_CACHE_DURATION))
                $app->settings->set($app->settings::APP_MODULE_ARMORY_CACHE_DURATION, 120);

            if (!$app->settings->get($app->settings::APP_MODULE_ARMORY_PER_PAGE))
                $app->settings->set($app->settings::APP_MODULE_ARMORY_PER_PAGE, 20);
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
