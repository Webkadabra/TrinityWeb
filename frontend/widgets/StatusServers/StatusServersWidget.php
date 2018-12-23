<?php
namespace frontend\widgets\StatusServers;

use core\models\chars\Characters;
use Yii;
use yii\base\Widget;

class StatusServersWidget extends Widget
{
    const UPDATE_TIME = 120;
    
    public function run() {
        $servers = Yii::$app->DBHelper->getServers();
        $shared_online = 0;
        $status_list = null;
        $status_data = Yii::$app->cache->get('widget-status_servers');
        if($status_data === false) {
            foreach($servers as $server) {
                $status_list[$server['id']]['id'] = $server['auth_id'] . '_' .$server['realm_id'];
                $status_list[$server['id']]['name'] = $server['realm_name'];
                if (!$world = @fsockopen($server['realm_address'],$server['realm_port'],$errno,$errstr,1)) {//timeout 1 second
                    $status_list[$server['id']]['status'] = Yii::$app->TrinityWeb::OFFLINE;
                    $status_list[$server['id']]['count'] = 0;
                    Characters::clearCacheOnlineByServer($server['auth_id'],$server['realm_id']);
                } else {
                    $status_list[$server['id']]['status'] = Yii::$app->TrinityWeb::ONLINE;
                    $onlineList = Characters::getOnlineByServer($server['auth_id'],$server['realm_id']);
                    $status_list[$server['id']]['count'] = count($onlineList);
                    $shared_online += $status_list[$server['id']]['count'];
                    fclose($world);
                }
            }
            $status_data['status_list'] = $status_list;
            $status_data['shared_online'] = $shared_online;
            Yii::$app->cache->set('widget-status_servers',$status_data,self::UPDATE_TIME);
        }

        return $this->render('index', [
            'status_list'   => $status_data['status_list'],
            'shared_online' => $status_data['shared_online'],
        ]);
    }
}