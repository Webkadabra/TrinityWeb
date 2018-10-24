<?php
namespace core\modules\installer;

use Yii;
use yii\base\Module as BaseModule;
use yii\web\Application;
use yii\web\GroupUrlRule;
use yii\base\BootstrapInterface;
use yii\web\ForbiddenHttpException;

use core\modules\installer\helpers\TourHelper;

class ModuleInstall extends BaseModule implements BootstrapInterface
{

    public $id = 'install';
    public $version = '@beta';
    public $layout = 'install';
    public $defaultRoute = 'step/prerequisites';
    public $allowedIPs = ['127.0.0.1', '::1'];
    /**
     * @var string
     */
    public $controllerNamespace = 'core\modules\installer\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        TourHelper::initTour();

        $this->allowedIPs[] = env('ACCESS_INSTALL');
        array_unique($this->allowedIPs);

        $this->setAliases(['@installer' => __DIR__]);

    }

    public function bootstrap($app)
    {
        if ($app instanceof Application) {
            $this->registerTranslations();
            $this->addUrlManagerRules($app);
        }
    }

    public function beforeAction($action)
    {
        if ($this->checkAccess()) {
            $last_step = TourHelper::getStep();
            $requested_step = TourHelper::getStepByAction($action->id);
            if($requested_step > $last_step) {
                Yii::$app->session->setFlash('error',Yii::t('installer','Requested step not allowed now!'));
                Yii::$app->response->redirect([TourHelper::getActionByStep($last_step)]);
                return false;
            }
            return parent::beforeAction($action);
        } else {
            die('You are not allowed to access this page.');
        }
    }

    /**
     * @return bool whether the module can be accessed by the current user
     */
    public function checkAccess()
    {
        $ip = Yii::$app->request->getUserIP();
        foreach ($this->allowedIPs as $filter) {
            if ($filter === '*' || $filter === $ip || (($pos = strpos($filter, '*')) !== false && !strncmp($ip, $filter, $pos))) {
                return true;
            }
        }
        return false;
    }

    protected function addUrlManagerRules($app)
    {
        $app->urlManager->addRules([new GroupUrlRule([
            'prefix' => $this->id,
            'rules' => require __DIR__ . '/url-rules.php',
        ])], true);
    }

    public function registerTranslations()
    {
        \Yii::$app->i18n->translations['installer'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'sourceLanguage' => 'en-US',
            'basePath' => '@installer/messages'
        ];
    }
}