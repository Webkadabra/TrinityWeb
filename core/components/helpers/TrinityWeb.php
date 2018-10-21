<?php
namespace core\components\helpers;

use Yii;
use yii\base\Component;
use yii\helpers\FileHelper;

use core\components\settings\Settings;

use core\models\WidgetCarouselItem;

class TrinityWeb extends Component
{

    const IMPORTED = 'imported';
    const NOT_IMPORTED = 'not_imported';

    const OFFLINE = 'offline';
    const ONLINE = 'online';

    public static function getThemes() {
        $appThemesAlias = Yii::getAlias('@frontend') . DIRECTORY_SEPARATOR . 'themes';
        $existThemes = FileHelper::findDirectories(Yii::getAlias('@frontend') . DIRECTORY_SEPARATOR . 'themes', ['recursive' => false]);

        $themes = [];
        foreach($existThemes as $key => &$theme) {
            $theme = str_replace($appThemesAlias . DIRECTORY_SEPARATOR,'',$theme);
            $themes[$theme] = $theme;
        }

        return $themes;
    }

    public function init()
    {
        parent::init();
    }

    /**
     * Check if application installed
     * @return bool
     */
    public static function isAppInstalled()
    {
        if(Yii::$app->has('db')) {
            if(Yii::$app->TrinityWeb::checkDBConnection()) {
                if (Yii::$app->TrinityWeb::isDBImported()) {
                    if (Yii::$app->settings->get(Settings::APP_STATUS) === Settings::INSTALLED) return true;
                }
            }
        }
        return false;
    }

    /**
     * Check if db imported
     * @return bool
     */
    public static function isDBImported()
    {
        if (Yii::$app->db->schema->getTableSchema(WidgetCarouselItem::tableName(), true) !== null) {
            return true;
        }
        return false;
    }

    /**
     * Check connection to db
     * @param string $key
     * @return bool
     */
    public static function checkDBConnection($key = 'db')
    {
        try {
            Yii::$app->{$key}->open();
            if(Yii::$app->{$key}->isActive) return true;
        } catch (\Exception $ex) {}
        return false;
    }

    /**
     * Check - if application in maintenance mode
     * @return bool
     */
    public static function isAppMaintenanceMode()
    {
        if(!self::checkDBConnection()) return true;
        return Yii::$app->settings->get(Settings::APP_MAINTENANCE) == Settings::ENABLED;
    }

    /**
     * Execute YII command
     * @param $command
     * @return array
     */
    public static function executeCommand($command)
    {
        $output = array();
        $return_var = -1;
        $command = 'php ' . Yii::getAlias('@console') . '/yii' . " $command 2>&1";
        $last_line = exec($command, $output, $return_var);

        return [
            'command' => $command,
            'output' => $output,
            'last_line' => $last_line
        ];

    }

    /**
     * Deletes the value of element with the specified key from cache array.
     * @param string $key a key identifying the value to be deleted from cache.
     * @param string $element a key of the element.
     * @return bool
     */
    public static function deleteCacheElement($key, $element)
    {
        $cache = Yii::$app->cache->get($key);
        if ($cache !== false && isset($cache[$element])) {
            unset($cache[$element]);
            return Yii::$app->cache->set($key, $cache);
        }
        return true;
    }

    /**
     * Returns HTMLPurifier configuration set.
     * @param string $type set name
     * @return array configuration
     */
    public static function purifierConfig($type = '')
    {
        switch ($type) {
            case 'full':
                $config = [
                    'HTML.Allowed' => 'p[class],br,b,strong,i,em,u,s,a[href|target],ul,li,ol,span[style|class],h1,h2,h3,h4,h5,h6,sub,sup,blockquote,pre[class],img[src|alt],iframe[class|frameborder|src],hr',
                    'CSS.AllowedProperties' => 'color,background-color',
                    'HTML.SafeIframe' => true,
                    'URI.SafeIframeRegexp' => '%^(https?:)?//(www\.youtube(?:-nocookie)?\.com/embed/|player\.vimeo\.com/video/)%',
                    'Attr.AllowedFrameTargets' => ['_blank']
                ];
                break;
            case 'markdown':
                $config = [
                    'HTML.Allowed' => 'p,br,b,strong,i,em,u,s,a[href|target],ul,li,ol,hr,h1,h2,h3,h4,h5,h6,span,pre,code,table,tr,td,th,blockquote,img[src|alt]',
                    'Attr.AllowedFrameTargets' => ['_blank']
                ];
            case 'default':
            default:
                $config = [
                    'HTML.Allowed' => 'p[class],br,b,strong,i,em,u,s,a[href|target],ul,li,ol,hr',
                    'Attr.AllowedFrameTargets' => ['_blank']
                ];
        }

        return $config;
    }

}