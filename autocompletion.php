<?php
/**
 * Yii bootstrap file.
 * Used for enhanced IDE code autocompletion.
 * Note: To avoid "Multiple Implementations" PHPStorm warning and make autocomplete faster
 * exclude or "Mark as Plain Text" vendor/yiisoft/yii2/Yii.php file
 */
class Yii extends \yii\BaseYii
{
    /**
     * @var BaseApplication|WebApplication|ConsoleApplication the application instance
     */
    public static $app;
}

/**
 * Class BaseApplication
 * Used for properties that are identical for both WebApplication and ConsoleApplication
 *
 * @property trntv\filekit\Storage $fileStorage
 * @property yii\web\UrlManager $urlManagerFrontend UrlManager for frontend application.
 * @property yii\web\UrlManager $urlManagerBackend UrlManager for backend application.
 * @property yii\web\UrlManager $urlManagerApi UrlManager for api application.
 * @property yii\web\UrlManager $urlManagerStorage UrlManager for storage application.
 * @property core\components\settings\Settings $settings Application settings.
 * @property core\components\helpers\PermissionHelper $PermissionHelper Application permission helper.
 * @property core\components\helpers\SeoHelper $SeoHelper Application seo helper.
 * @property core\components\helpers\i18nHelper $i18nHelper Application i18n helper.
 * @property core\components\helpers\TrinityWeb $TrinityWeb TrinityWeb component.
 * @property core\components\helpers\DBHelper $DBHelper DBHelper component.
 * @property core\components\helpers\Armory $armoryHelper Armory component.
 * @property core\components\logs\Log $LogHelper Application log helper.
 * @property trntv\glide\components\Glide $glide
 * @property trntv\bus\CommandBus $commandBus
 */
abstract class BaseApplication extends yii\base\Application
{
}

/**
 * Class WebApplication
 * Include only Web application related components here
 *
 * @property User $user User component.
 */
class WebApplication extends yii\web\Application
{
}

/**
 * Class ConsoleApplication
 * Include only Console application related components here
 */
class ConsoleApplication extends yii\console\Application
{
}

/**
 * User component
 * Include only Web application related components here
 *
 * @property \core\models\User $identity User model.
 * @method \core\models\User getIdentity() returns User model.
 */
class User extends \yii\web\User
{
}