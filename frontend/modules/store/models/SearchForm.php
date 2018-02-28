<?php

namespace frontend\modules\store\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

use common\models\shop\ShopItems;

/**
 * SearchForm
 */
class SearchForm extends Model
{
    
    const PAGE_SIZE = 25;
    
    public $server;
    public $order;
    public $field_order;
    public $query;
    public $dCoinsFrom;
    public $dCoinsTo;
    public $vCoinsFrom;
    public $vCoinsTo;
    public $discount = false;
    
    public function __construct($config = array()) {
        parent::__construct($config);
        $this->field_order = 'id';
        $this->order = SORT_DESC;
    }
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['server','field_order'], 'safe'],
            [['order','dCoinsFrom','dCoinsTo','vCoinsFrom','vCoinsTo'], 'integer'],
            ['query', 'string', 'min' => 2],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'server' => Yii::t('common', 'Игровой мир'),
            'query' => Yii::t('armory', 'Строка поиска'),
            'order' => Yii::t('common', 'Сортировать по...'),
            'discount' => Yii::t('store', 'Только со скидкой'),
        ];
    }
    
    public function getServers() {
        $servers = Yii::$app->CharactersDbHelper->getServers(true);
        $data = [];
        foreach($servers as $server) {
            $data[$server] = $server;
        }
        return $data;
    }
    
    public function getFieldsToSotring() {
        return [
            'id' => Yii::t('store','По номеру'),
            'name' => Yii::t('store','По имени'),
            'dCoins' => Yii::t('store','По dCoins'),
            'vCoins' => Yii::t('store','По vCoins'),
            'realm_id' => Yii::t('store','По игровому миру'),
            'discount_end' => Yii::t('store','По окончанию скидки'),
        ];
    }
    
    public function findItems($params) {
        $this->load($params);
        
        $query = ShopItems::find()->where(['visible' => false])->orderBy([$this->field_order => $this->order]);
        
        $query->andFilterWhere(['<=', 'dCoinsTo', $this->dCoinsTo]);
        $query->andFilterWhere(['>=', 'dCoinsFrom', $this->dCoinsFrom]);
        
        $query->andFilterWhere(['<=', 'vCoinsTo', $this->vCoinsTo]);
        $query->andFilterWhere(['>=', 'vCoinsFrom', $this->vCoinsFrom]);
        
        if($this->discount) {
            $query->andWhere(['not', ['discount' => null]]);
        }
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
        $data = Yii::$app->cache->get(Yii::$app->request->url);
        $counter = Yii::$app->cache->get(Yii::$app->request->url . '_counter');
        if($this->query) {    
            if($data === false || $counter === false) {
                $data = $dataProvider->getModels();
                $counter = $dataProvider->getTotalCount();
                Yii::$app->cache->set(Yii::$app->request->url . '_counter',$counter,Yii::$app->keyStorage->get('frontend.cache_store_search'));
                Yii::$app->cache->set(Yii::$app->request->url,$data,Yii::$app->keyStorage->get('frontend.cache_store_search'));
            }
        }
        return ['result' => $data, 'counter' => $counter];
    }
    
    public function formName() {return '';}
    
}