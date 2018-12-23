<?php

namespace core\models\chars;

use core\base\models\CharacterCoreModel;
use Yii;

/**
 * This is the model class for table "characters".
 *
 * @property integer $guid
 * @property integer $account
 * @property string $name
 * @property integer $race
 * @property integer $class
 * @property integer $gender
 * @property integer $level
 * @property integer $xp
 * @property integer $money
 * @property integer $skin
 * @property integer $face
 * @property integer $hairStyle
 * @property integer $hairColor
 * @property integer $facialStyle
 * @property integer $bankSlots
 * @property integer $restState
 * @property integer $playerFlags
 * @property double $position_x
 * @property double $position_y
 * @property double $position_z
 * @property integer $map
 * @property integer $instance_id
 * @property integer $instance_mode_mask
 * @property double $orientation
 * @property string $taximask
 * @property integer $online
 * @property integer $cinematic
 * @property integer $totaltime
 * @property integer $leveltime
 * @property integer $logout_time
 * @property integer $is_logout_resting
 * @property double $rest_bonus
 * @property integer $resettalents_cost
 * @property integer $resettalents_time
 * @property double $trans_x
 * @property double $trans_y
 * @property double $trans_z
 * @property double $trans_o
 * @property integer $transguid
 * @property integer $extra_flags
 * @property integer $stable_slots
 * @property integer $at_login
 * @property integer $zone
 * @property integer $death_expire_time
 * @property string $taxi_path
 * @property integer $arenaPoints
 * @property integer $totalHonorPoints
 * @property integer $todayHonorPoints
 * @property integer $yesterdayHonorPoints
 * @property integer $totalKills
 * @property integer $todayKills
 * @property integer $yesterdayKills
 * @property integer $chosenTitle
 * @property string $knownCurrencies
 * @property integer $watchedFaction
 * @property integer $drunk
 * @property integer $health
 * @property integer $power1
 * @property integer $power2
 * @property integer $power3
 * @property integer $power4
 * @property integer $power5
 * @property integer $power6
 * @property integer $power7
 * @property integer $latency
 * @property integer $talentGroupsCount
 * @property integer $activeTalentGroup
 * @property string $exploredZones
 * @property string $equipmentCache
 * @property integer $ammoId
 * @property string $knownTitles
 * @property integer $actionBars
 * @property integer $grantableLevels
 * @property integer $deleteInfos_Account
 * @property string $deleteInfos_Name
 * @property integer $deleteDate
 *
 * @property CharacterStats $stats
 * @property GuildMember $guild
 * @property CharacterInventory $equipment
 * @property ArmoryProfessions $generalProfessions
 * @property bool $specGroup1 [tinyint(3)]
 * @property bool $specGroup2 [tinyint(3)]
 *
 */
class Characters extends CharacterCoreModel
{
    const UPDATE_TIME = 120;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%characters}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['guid', 'name', 'taximask'], 'required'],
            [['guid', 'account', 'race', 'class', 'gender', 'level', 'xp', 'money', 'skin', 'face', 'hairStyle', 'hairColor', 'facialStyle', 'bankSlots', 'restState', 'playerFlags', 'map', 'instance_id', 'instance_mode_mask', 'online', 'cinematic', 'totaltime', 'leveltime', 'logout_time', 'is_logout_resting', 'resettalents_cost', 'resettalents_time', 'transguid', 'extra_flags', 'stable_slots', 'at_login', 'zone', 'death_expire_time', 'arenaPoints', 'totalHonorPoints', 'todayHonorPoints', 'yesterdayHonorPoints', 'totalKills', 'todayKills', 'yesterdayKills', 'chosenTitle', 'knownCurrencies', 'watchedFaction', 'drunk', 'health', 'power1', 'power2', 'power3', 'power4', 'power5', 'power6', 'power7', 'latency', 'talentGroupsCount', 'activeTalentGroup', 'ammoId', 'actionBars', 'grantableLevels', 'deleteInfos_Account', 'deleteDate'], 'integer'],
            [['position_x', 'position_y', 'position_z', 'orientation', 'rest_bonus', 'trans_x', 'trans_y', 'trans_z', 'trans_o'], 'number'],
            [['taximask', 'taxi_path', 'exploredZones', 'equipmentCache', 'knownTitles'], 'string'],
            [['name', 'deleteInfos_Name'], 'string', 'max' => 12],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'guid'                 => 'Guid',
            'account'              => 'Account',
            'name'                 => 'Name',
            'race'                 => 'Race',
            'class'                => 'Class',
            'gender'               => 'Gender',
            'level'                => 'Level',
            'xp'                   => 'Xp',
            'money'                => 'Money',
            'skin'                 => 'Skin',
            'face'                 => 'Face',
            'hairStyle'            => 'Hair Style',
            'hairColor'            => 'Hair Color',
            'facialStyle'          => 'Facial Style',
            'bankSlots'            => 'Bank Slots',
            'restState'            => 'Rest State',
            'playerFlags'          => 'Player Flags',
            'position_x'           => 'Position X',
            'position_y'           => 'Position Y',
            'position_z'           => 'Position Z',
            'map'                  => 'Map',
            'instance_id'          => 'Instance ID',
            'instance_mode_mask'   => 'Instance Mode Mask',
            'orientation'          => 'Orientation',
            'taximask'             => 'Taximask',
            'online'               => 'Online',
            'cinematic'            => 'Cinematic',
            'totaltime'            => 'Totaltime',
            'leveltime'            => 'Leveltime',
            'logout_time'          => 'Logout Time',
            'is_logout_resting'    => 'Is Logout Resting',
            'rest_bonus'           => 'Rest Bonus',
            'resettalents_cost'    => 'Resettalents Cost',
            'resettalents_time'    => 'Resettalents Time',
            'trans_x'              => 'Trans X',
            'trans_y'              => 'Trans Y',
            'trans_z'              => 'Trans Z',
            'trans_o'              => 'Trans O',
            'transguid'            => 'Transguid',
            'extra_flags'          => 'Extra Flags',
            'stable_slots'         => 'Stable Slots',
            'at_login'             => 'At Login',
            'zone'                 => 'Zone',
            'death_expire_time'    => 'Death Expire Time',
            'taxi_path'            => 'Taxi Path',
            'arenaPoints'          => 'Arena Points',
            'totalHonorPoints'     => 'Total Honor Points',
            'todayHonorPoints'     => 'Today Honor Points',
            'yesterdayHonorPoints' => 'Yesterday Honor Points',
            'totalKills'           => 'Total Kills',
            'todayKills'           => 'Today Kills',
            'yesterdayKills'       => 'Yesterday Kills',
            'chosenTitle'          => 'Chosen Title',
            'knownCurrencies'      => 'Known Currencies',
            'watchedFaction'       => 'Watched Faction',
            'drunk'                => 'Drunk',
            'health'               => 'Health',
            'power1'               => 'Power1',
            'power2'               => 'Power2',
            'power3'               => 'Power3',
            'power4'               => 'Power4',
            'power5'               => 'Power5',
            'power6'               => 'Power6',
            'power7'               => 'Power7',
            'latency'              => 'Latency',
            'talentGroupsCount'    => 'Talent Groups Count',
            'activeTalentGroup'    => 'Active Talent Group',
            'exploredZones'        => 'Explored Zones',
            'equipmentCache'       => 'Equipment Cache',
            'ammoId'               => 'Ammo ID',
            'knownTitles'          => 'Known Titles',
            'actionBars'           => 'Action Bars',
            'grantableLevels'      => 'Grantable Levels',
            'deleteInfos_Account'  => 'Delete Infos  Account',
            'deleteInfos_Name'     => 'Delete Infos  Name',
            'deleteDate'           => 'Delete Date',
        ];
    }
    /**
    * Поиск по имени персонажа
    * @param string $name Имя персонажа
    * @return \yii\db\ActiveRecord
    */
    public function findByName($name)
    {
        return Characters::find()->where(['name' => $name])->one();
    }

    /**
    * Teleport character to home by QUERY
    * @return bool
    */
    public function goHome()
    {
        if($this->home) {
            $this->position_x = $this->home->posX;
            $this->position_y = $this->home->posY;
            $this->position_z = $this->home->posZ;
            $this->map = $this->home->mapId;
            $this->zone = $this->home->zoneId;
            $this->save();

            return true;
        }

        return false;
    }

    /**
     * Get online list by server
     * @param $auth_id
     * @param $realm_id
     * @throws \yii\base\InvalidConfigException
     * @return array|mixed|\yii\db\ActiveRecord[]
     */
    public static function getOnlineByServer($auth_id, $realm_id)
    {
        $cache_time = 120;
        $cache_key = self::getOnlineCacheKey($auth_id, $realm_id);
        $list = Yii::$app->cache->get($cache_key);
        if($list === false) {
            $list = self::find()
                ->where([
                    'online' => 1
                ])
                ->asArray()
                ->all(Yii::$app->DBHelper::getConnection(null, self::buildComponentName($auth_id,$realm_id)));
            Yii::$app->cache->set($cache_key, $list, $cache_time);
        }

        return $list;
    }

    /**
     * @param $server_id
     * @param $realm_id
     */
    public static function clearCacheOnlineByServer($server_id, $realm_id)
    {
        $cache_key = self::getOnlineCacheKey($server_id,$realm_id);
        Yii::$app->cache->delete($cache_key);
    }

    /**
     * @param $server_id
     * @param $realm_id
     * @return string
     */
    public static function getOnlineCacheKey($server_id, $realm_id)
    {
        return "characters.online.server_{$server_id}_{$realm_id}";
    }

    public function getArenaStats() {
        return $this->hasMany(CharacterArenaStats::class,['guid' => 'guid']);
    }

    public function getStats() {
        return $this->hasOne(CharacterStats::class,['guid' => 'guid']);
    }

    public function getArenaRating() {
        return $this->hasMany(ArenaTeamMember::class,['guid' => 'guid'])->with(['team']);
    }

    public function getGuild() {
        return $this->hasOne(GuildMember::class,['guid' => 'guid']);
    }
}