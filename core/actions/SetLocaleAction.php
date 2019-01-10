<?php

namespace core\actions;

use Yii;
use yii\base\Action;
use yii\base\InvalidArgumentException;
use yii\web\Cookie;

/**
 * Class SetLocaleAction
 * @package core\actions
 *
 * Example:
 *
 *   public function actions()
 *   {
 *       return [
 *           'set-locale'=>[
 *               'class'=>'core\actions\SetLocaleAction',
 *               'locales'=>[
 *                   'en-US', 'ru-RU', 'uk-UA'
 *               ],
 *               'localeCookieName'=>'_locale',
 *               'callback'=>function($action){
 *                   return $this->controller->redirect(/.. some url ../)
 *               }
 *           ]
 *       ];
 *   }
 */
class SetLocaleAction extends Action
{
    /**
     * @var array List of available locales
     */
    public $locales;

    /**
     * @var string
     */
    public $localeCookieName = '_locale';

    /**
     * @var integer
     */
    public $cookieExpire;

    /**
     * @var string
     */
    public $cookieDomain;

    /**
     * @var \Closure
     */
    public $callback;

    /**
     * @param $locale
     * @return mixed|static
     */
    public function run($locale)
    {
        $exist = false;

        foreach($this->locales as $_locale) {
            if($_locale['language_id'] === $locale) $exist = true;
        }

        if (!$exist) {
            $locale = Yii::$app->sourceLanguage;
        }

        $cookie = new Cookie([
            'name'   => $this->localeCookieName,
            'value'  => $locale,
            'expire' => $this->cookieExpire ?: time() + 60 * 60 * 24 * 365,
            'domain' => $this->cookieDomain ?: '',
        ]);

        Yii::$app->getResponse()->getCookies()->add($cookie);

        if ($this->callback && $this->callback instanceof \Closure) {
            return call_user_func($this->callback, $this, $locale);
        }

        return Yii::$app->response->redirect(Yii::$app->request->referrer ?: Yii::$app->homeUrl);
    }
}
