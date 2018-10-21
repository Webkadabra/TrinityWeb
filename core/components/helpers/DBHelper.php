<?php

namespace core\components\helpers;

use Yii;
use yii\base\Exception;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;
use yii\web\Cookie;
use yii\web\NotFoundHttpException;

use core\models\Server;

class DBHelper
{

    const AUTH_SERVER_COOKIE = 'twA';
    const REALM_SERVER_COOKIE = 'twR';

    /**
     * Get DB connection by componentPrefix & componentName
     * @param null|string $component_prefix
     * @param null $name
     * @return \yii\db\Connection|Object
     * @throws InvalidConfigException
     */
    public function getConnection($component_prefix = null, $name = null)
    {
        if($name !== '' && $name !== false && $name !== null) {
            try {
                return Yii::$app->get("{$component_prefix}{$name}");
            } catch (\Exception $exc) {
                throw new InvalidConfigException(Yii::t('common','Error during connection to {component_prefix}{name}', [
                    'component_prefix' => $component_prefix,
                    'name' => $name
                ]));
            }
        } else {
            throw new InvalidConfigException(Yii::t('common','Error - empty connection config'));
        }
    }

    /**
     * Set server for current user
     * @param $auth_id
     * @param $realm_id
     * @return bool|Server
     */
    public function setServerValue($auth_id, $realm_id)
    {
        if(self::isServerExist($auth_id, $realm_id)) {
            if(Yii::$app->user->isGuest) {
                Yii::$app->response->cookies->add(new Cookie([
                    'name' => self::AUTH_SERVER_COOKIE,
                    'value' => $auth_id
                ]));

                Yii::$app->response->cookies->add(new Cookie([
                    'name' => self::REALM_SERVER_COOKIE,
                    'value' => $realm_id
                ]));

            } else {
                Yii::$app->user->identity->auth_id = $auth_id;
                Yii::$app->user->identity->realm_id = $realm_id;
                Yii::$app->user->identity->character_id = null;
                Yii::$app->user->identity->save();
            }
            return Server::findOne(['realm_id' => $realm_id, 'auth_id' => $auth_id]);
        }
        return false;
    }

    /**
     * Check exist server
     * @param $auth_id
     * @param $realm_id
     * @return bool
     */
    public function isServerExist($auth_id, $realm_id)
    {
        foreach(self::getServers() as $server_data) {
            if($auth_id == $server_data['auth_id'] && $realm_id == $server_data['realm_id']) return true;
        }
        return false;
    }

    /**
     * Set default server (first in database)
     * @return null | Server
     * @throws Exception
     */
    public function setDefault()
    {
        if(Yii::$app->user->isGuest) {

            $auth_id = Yii::$app->request->cookies->getValue(self::AUTH_SERVER_COOKIE);
            $realm_id = Yii::$app->request->cookies->getValue(self::REALM_SERVER_COOKIE);

            if ($auth_id && $realm_id) {
                $server = Server::findOne(['auth_id' => $auth_id, 'realm_id' => $realm_id]);
                if ($server) return $server;
            }

            $servers = self::getServers();
            if (isset($servers[0])) {
                $server_data = $servers[0];
                if ($server_data) {
                    if ($server = self::setServerValue($server_data['auth_id'], $server_data['realm_id'])) return $server;
                }
            }
        } else {
            if(!Yii::$app->user->identity->auth_id || !Yii::$app->user->identity->realm_id) {
                $server = Server::find()->one();
                if($server) {
                    if($selectedServer = self::setServerValue($server->auth_id,$server->realm_id)) return $selectedServer;
                }
            }
            if(self::isServerExist(Yii::$app->user->identity->auth_id,Yii::$app->user->identity->realm_id)) {
                return Server::findOne([
                    'auth_id' => Yii::$app->user->identity->auth_id,
                    'realm_id' => Yii::$app->user->identity->realm_id
                ]);
            } else {
                $server_data = self::getServers()[0];
                if($server_data) {
                    if($server = self::setServerValue($server_data['auth_id'],$server_data['realm_id'])) return $server;
                }
            }
        }
        throw new Exception("Can not set auth & realm server");
    }

    /**
     * Get list servers
     * @param bool $as_associated return as associated
     * @return array
     */
    public function getServers($as_associated = false)
    {
        if($as_associated == true) {
            $cache_key = 'core.helpers.list_servers_assoc';
            $data = Yii::$app->cache->get($cache_key);
            if($data === false) {
                $data = ArrayHelper::map(Server::find()->asArray()->all(),'id', 'realm_name');
                Yii::$app->cache->set($cache_key,$data);
            }
        } else {
            $cache_key = 'core.helpers.list_servers';
            $data = Yii::$app->cache->get($cache_key);
            if($data === false) {
                $data = Server::find()->asArray()->all();
                Yii::$app->cache->set($cache_key,$data);
            }
        }
        return $data;
    }

    /**
     * Get server by NAME
     * @param string $name
     * @return Server|null
     * @throws NotFoundHttpException
     */
    public function getServerByName($name)
    {
        $model = Server::findOne(['realm_name' => $name]);
        if($model) {
            return $model;
        }
        throw new NotFoundHttpException("Server with {$name} not found");
    }

    /**
     * Get NAME for current server
     * @param bool $to_lower
     * @return string|null
     * @throws Exception
     */
    public function getServerName($to_lower = false) {
        return $to_lower ? mb_strtolower(self::setDefault()->realm_name) : self::setDefault()->realm_name;
    }

    /**
     * Get server_id from GET(server) parameter
     * @return Server|null
     * @throws NotFoundHttpException
     */
    public function getServerFromGet() {
        $name = Yii::$app->request->get('server');
        foreach($this::getServers(true) as $server_id => $server_name) {
            if($name == $server_name) return $this->getServerByName($server_name);
        }
        return null;
    }

    public function getServer($auth_id,$realm_id)
    {
        $model = Server::findOne(['auth_id' => $auth_id, 'realm_id' => $realm_id]);
        if($model) {
            return $model;
        }
        throw new NotFoundHttpException("Server {$realm_id} on auth {$auth_id} not found");
    }

}