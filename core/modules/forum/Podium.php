<?php

namespace core\modules\forum;

use core\modules\forum\log\DbTarget;
use core\modules\forum\maintenance\Maintenance;
use core\modules\forum\models\Activity;
use core\modules\forum\slugs\PodiumSluggableBehavior;
use Yii;
use yii\base\Action;
use yii\base\Application;
use yii\base\BootstrapInterface;
use yii\base\InvalidConfigException;
use yii\base\Module;
use yii\caching\Cache;
use yii\console\Application as ConsoleApplication;
use yii\db\Connection;
use yii\i18n\Formatter;
use yii\rbac\DbManager;
use yii\web\Application as WebApplication;
use yii\web\GroupUrlRule;
use yii\web\Response;
use yii\web\User;

/**
 * Podium Module
 * Yii 2 Forum Module
 *
 * @property PodiumCache $podiumCache
 * @property PodiumConfig $podiumConfig
 * @property Formatter $formatter
 * @property DbManager $rbac
 * @property User $user
 * @property Connection $db
 * @property Cache $cache
 * @property boolean $installed
 * @property string $version
 * @property PodiumComponent $podiumComponent
 * @property array $loginUrl
 * @property array $registerUrl
 * @property string $slugGenerator
 */
class Podium extends Module implements BootstrapInterface
{
    /**
     * @var array List of IPs that are allowed to access installation mode of this module.
     * Each array element represents a single IP filter which can be either an IP address or an address with wildcard
     * (e.g. `192.168.0.*`) to represent a network segment.
     * The default value is `['127.0.0.1', '::1']`, which means the module can only be accessed by localhost.
     */
    public $allowedIPs = ['127.0.0.1', '::1'];

    /**
     * @var bool|string|array Module user component.
     * Since version 0.5 it can be:
     * - true for own Podium component configuration,
     * - string with inherited component ID,
     * - array with custom configuration (look at registerIdentity() to see what Podium uses).
     */
    public $userComponent = true;

    /**
     * @var bool|string|array Module RBAC component.
     * Since version 0.5 it can be:
     * - true for own Podium component configuration,
     * - string with inherited component ID,
     * - array with custom configuration (look at registerAuthorization() to see what Podium uses).
     */
    public $rbacComponent = true;

    /**
     * @var bool|string|array Module formatter component.
     * It can be:
     * - true for own Podium component configuration,
     * - string with inherited component ID,
     * - array with custom configuration (look at registerFormatter() to see what Podium uses).
     * @since 0.5
     */
    public $formatterComponent = true;

    /**
     * @var string|array Module db component.
     * It can be:
     * - string with inherited component ID,
     * - array with custom configuration.
     * @since 0.5
     */
    public $dbComponent = 'db';

    /**
     * @var bool|string|array Module cache component.
     * It can be:
     * - false for not using cache,
     * - string with inherited component ID,
     * - array with custom configuration.
     * @since 0.5
     */
    public $cacheComponent = false;

    /**
     * @var string Module inherited user password_hash field name.
     * This is used for profile updating confirmation.
     * Default value is 'password_hash'.
     */
    public $userPasswordField = 'password_hash';

    /**
     * @var string Module inherited username field name.
     * When provided value of this field is used as default Podium nickname and can not be changed from within Podium.
     * If you want to use it and your User name's model field is 'username' set userNameField to 'username'.
     * @since 0.8
     */
    public $userNameField;

    /**
     * @var string Default route for Podium.
     * @since 0.2
     */
    public $defaultRoute = 'forum';

    /**
     * @var bool Value of identity Cookie 'secure' parameter.
     * @since 0.2
     */
    public $secureIdentityCookie = false;

    /**
     * @var callable Callback that will be called to determine the type of Podium access for user.
     * The signature of the callback should be as follows:
     *      function ($user)
     * where $user is the user component.
     * The callback should return an integer value indicating access type:
     *  1 => member access,
     *  0 => guest access,
     * -1 => no access.
     * @since 0.6
     */
    public $accessChecker;

    /**
     * @var callable Callback that will be called in case Podium access has been denied for user.
     * The signature of the callback should be as follows:
     *      function ($user)
     * where $user is the user component.
     * @since 0.6
     */
    public $denyCallback;

    /**
     * @var string Qualified name of class responsible for generating Podium slugs.
     * You can implement your own generator by extending core\modules\forum\slugs\PodiumSluggableBehavior -
     * see this class for details.
     * @since 0.8
     */
    public $slugGenerator;

    public $layout = 'main';

    private $_cache;

    private $_config;

    private $_component;

    /**
     * Initializes the module for Web application.
     * Sets Podium alias (@forum) and layout.
     * Registers user identity, authorization, translations, formatter, db, and cache.
     * @throws InvalidConfigException
     */
    public function init()
    {
        parent::init();
        $this->setAliases(['@forum' => '@core/modules/forum']);
        if (Yii::$app instanceof WebApplication) {
            $this->podiumComponent->registerComponents();
            if (!is_string($this->slugGenerator)) {
                $this->slugGenerator = PodiumSluggableBehavior::class;
            }
        } else {
            $this->podiumComponent->registerConsoleComponents();
        }
    }

    /**
     * Bootstrap method to be called during application bootstrap stage.
     * Adding routing rules and log target.
     * @param Application $app the application currently running
     */
    public function bootstrap($app)
    {
        /* @var \BaseApplication $app */
        if($app->TrinityWeb::isAppInstalled()) {
            if ($app instanceof WebApplication) {
                $this->setDefaultSettings(Yii::$app);
                $this->addUrlManagerRules($app);
                $this->setPodiumLogTarget($app);
            } elseif ($app instanceof ConsoleApplication) {
                $this->controllerNamespace = 'core\modules\forum\console';
            }
        }
    }

    /**
     * Registers user activity after every action.
     * @see Activity::add()
     * @param Action $action the action just executed
     * @param mixed $result the action return result
     * @return mixed the processed action result
     */
    public function afterAction($action, $result)
    {
        if (Yii::$app instanceof WebApplication && !in_array($action->id, ['import', 'run', 'update', 'level-up'], true)) {
            Activity::add();
        }

        return parent::afterAction($action, $result);
    }

    public function beforeAction($action) {
        parent::beforeAction($action);
        if(Yii::$app->settings->get(Yii::$app->settings::APP_MODULE_FORUM_STATUS) !== Yii::$app->settings::ENABLED) {
            return Yii::$app->response->redirect(Yii::$app->homeUrl);
        }

        return parent::beforeAction($action);
    }

    /**
     * Returns Podium cache instance.
     * @return PodiumCache
     * @since 0.5
     */
    public function getPodiumCache()
    {
        if ($this->_cache === null) {
            $this->_cache = new PodiumCache;
        }

        return $this->_cache;
    }

    /**
     * Returns Podium configuration instance.
     * @return PodiumConfig
     * @since 0.5
     */
    public function getPodiumConfig()
    {
        if ($this->_config === null) {
            $this->_config = new PodiumConfig;
        }

        return $this->_config;
    }

    /**
     * Returns Podium installation flag.
     * @return bool
     */
    public function getInstalled()
    {
        return Maintenance::check();
    }

    /**
     * Appends module ID to the route.
     * @param string $route
     * @return string
     * @since 0.5
     */
    public function prepareRoute($route)
    {
        return '/' . $this->id . (substr($route, 0, 1) === '/' ? '' : '/') . $route;
    }

    /**
     * Redirects to Podium main controller's action.
     * @return Response
     */
    public function goPodium()
    {
        return Yii::$app->response->redirect([$this->prepareRoute('forum/index')]);
    }

    /**
     * Returns login URL.
     * @return array|null
     * @since 0.6
     */
    public function getLoginUrl()
    {
        if ($this->userComponent !== true) {
            return null;
        }

        return [$this->prepareRoute('account/login')];
    }

    /**
     * Returns registration URL.
     * @return array|null
     * @since 0.6
     */
    public function getRegisterUrl()
    {
        if ($this->userComponent !== true) {
            return null;
        }

        return [$this->prepareRoute('account/register')];
    }

    /**
     * Returns Podium component service.
     * @return PodiumComponent
     * @since 0.6
     */
    public function getPodiumComponent()
    {
        if ($this->_component === null) {
            $this->_component = new PodiumComponent($this);
        }

        return $this->_component;
    }

    /**
     * Returns instance of RBAC component.
     * @throws InvalidConfigException
     * @return DbManager
     * @since 0.5
     */
    public function getRbac()
    {
        return $this->podiumComponent->getComponent('rbac');
    }

    /**
     * Returns instance of formatter component.
     * @throws InvalidConfigException
     * @return Formatter
     * @since 0.5
     */
    public function getFormatter()
    {
        return $this->podiumComponent->getComponent('formatter');
    }

    /**
     * Returns instance of user component.
     * @throws InvalidConfigException
     * @return User
     * @since 0.5
     */
    public function getUser()
    {
        return $this->podiumComponent->getComponent('user');
    }

    /**
     * Returns instance of db component.
     * @throws InvalidConfigException
     * @return Connection
     * @since 0.5
     */
    public function getDb()
    {
        return $this->podiumComponent->getComponent('db');
    }

    /**
     * Returns instance of cache component.
     * @throws InvalidConfigException
     * @return Cache
     * @since 0.5
     */
    public function getCache()
    {
        return $this->podiumComponent->getComponent('cache');
    }

    /**
     * @inheritdoc
     */
    protected function defaultVersion()
    {
        return '0.7';
    }

    protected function setDefaultSettings($app)
    {
        if (!$app->settings->get($app->settings::APP_MODULE_FORUM_STATUS))
            $app->settings->set($app->settings::APP_MODULE_FORUM_STATUS, $app->settings::DISABLED);
    }

    /**
     * Adds UrlManager rules.
     * @param Application $app the application currently running
     * @since 0.2
     */
    protected function addUrlManagerRules($app)
    {
        $app->urlManager->addRules([new GroupUrlRule([
                'prefix' => $this->id,
                'rules'  => require __DIR__ . '/url-rules.php',
            ])], true);
    }

    /**
     * Sets Podium log target.
     * @param Application $app the application currently running
     * @since 0.2
     */
    protected function setPodiumLogTarget($app)
    {
        $dbTarget = new DbTarget;
        $dbTarget->logTable = '{{%log}}';
        $dbTarget->categories = ['core\modules\forum\*'];
        $dbTarget->logVars = [];
        $app->log->targets['podium'] = $dbTarget;
    }
}
