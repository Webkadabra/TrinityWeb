<?php

namespace frontend\modules\armory\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use core\models\chars\Characters;

/**
 * SearchForm
 */
class SearchForm extends Model
{
    
    public $server;
    public $query = '';

    /**
     * SearchForm constructor.
     * @param array $config
     * @throws \yii\base\Exception
     */
    public function __construct($config = array()) {
        parent::__construct($config);
        $this->server = Yii::$app->DBHelper->getServerName();
    }
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['server', 'query'], 'required'],
            ['server', 'string'],
            ['query', 'trim'],
            ['query', 'string', 'min' => 2],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'server' => Yii::t('core', 'Realm'),
            'query' => Yii::t('armory', 'Search...'),
        ];
    }
    
    public function getServers() {
        $servers = Yii::$app->DBHelper->getServers(true);
        $data = [];
        foreach($servers as $server) {
            $data[$server] = $server;
        }
        return $data;
    }
    
    public function findCharacters($params) {
        $this->load($params);
        $dataProvider = new ActiveDataProvider([
			'query' => Characters::find()->where([
                    'like',
                    'LOWER(name)',
                    mb_strtolower($this->query)
                ])
                ->orderBy(['guid' => SORT_DESC])
                ->with(['guild.guild'])
                ->asArray(),
			'pagination' => [
				'pageSize' => Yii::$app->settings->get(Yii::$app->settings::APP_MODULE_ARMORY_PER_PAGE),
			],
		]);
        $data = Yii::$app->cache->get(Yii::$app->request->url);
        $counter = Yii::$app->cache->get(Yii::$app->request->url . '_counter');
        if($this->query) {    
            if($data === false || $counter === false) {
                $data = $dataProvider->getModels();
                $counter = $dataProvider->getTotalCount();
                Yii::$app->cache->set(Yii::$app->request->url . '_counter',$counter,Yii::$app->settings->get(Yii::$app->settings::APP_MODULE_ARMORY_CACHE_DURATION));
                Yii::$app->cache->set(Yii::$app->request->url,$data,Yii::$app->settings->get(Yii::$app->settings::APP_MODULE_ARMORY_CACHE_DURATION));
            }
        }
        return ['result' => $data, 'counter' => $counter];
    }
    
    public function formName() {return '';}
    
}
