<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "web_shop_items".
 *
 * @property int $id
 * @property int $category_id
 * @property int $type
 * @property string $name
 * @property int $item_id
 * @property int $cost
 * @property double $discount
 * @property string $discount_end
 * @property int $realm_id
 *
 * @property ShopBasket[] $shopBaskets
 * @property ShopCategory $category
 * @property ShopPackageItems[] $shopPackageItems
 * @property ShopPackageItems[] $shopPackageItems0
 */
class ShopItems extends \yii\db\ActiveRecord
{
    
    const TYPE_OTHER = 0;
    const TYPE_GAME_ITEM = 1;
    const TYPE_GAME_VALUTE = 2;
    const TYPE_GAME_TITLE = 3;
    const TYPE_PACK = 4;
    const TYPE_ACCOUNT = 5;
    
    public $package = [];
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%shop_items}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id'], 'required'],
            [['category_id', 'type', 'item_id', 'cost', 'realm_id'], 'integer'],
            [['discount'], 'number'],
            [['discount_end','package'], 'safe'],
            [['name'], 'string', 'max' => 255],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => ShopCategory::className(), 'targetAttribute' => ['category_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'category_id' => Yii::t('common', 'Category ID'),
            'type' => Yii::t('common', 'Type'),
            'name' => Yii::t('common', 'Name'),
            'item_id' => Yii::t('common', 'Item ID'),
            'cost' => Yii::t('common', 'Cost'),
            'discount' => Yii::t('common', 'Discount'),
            'discount_end' => Yii::t('common', 'Discount End'),
            'realm_id' => Yii::t('common', 'Realm ID'),
            'package' => Yii::t('common', 'Пакет услуг'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRelationShopBaskets()
    {
        return $this->hasMany(ShopBasket::className(), ['item_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRelationCategory()
    {
        return $this->hasOne(ShopCategory::className(), ['id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRelationGetPackagesItem()
    {
        return $this->hasMany(ShopPackageItems::className(), ['shop_item_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRelationParentPackageItem()
    {
        return $this->hasMany(ShopPackageItems::className(), ['shop_parent_item_id' => 'id']);
    }
    
    public function getType() {
        foreach($this->getTypes() as $id => $type) {
            if($id == $this->type) return $type;
        }
    }
    
    public function getTypes() {
        return [
            Yii::t('app','Другое'),
            Yii::t('app','Игровой предмет'),
            Yii::t('app','Игровая валюта'),
            Yii::t('app','Звание'),
            Yii::t('app','Пакет'),
            Yii::t('app','Для уч. записи'),
        ];
    }
    
    public function listView($params) {
        $query = ShopItems::find();
        $this->load($params);
        $query->andWhere(['realm_id' => ['',Yii::$app->CharactersDbHelper->getServerId()]]);
        if($this->type) {
            $query->andWhere(['type' => $this->type]);
        }
        if($this->cost) {
            $query->andWhere(['cost' => $this->cost]);
        }
        if($this->category_id) {
            $query->andWhere(['category_id' => $this->category_id]);
        }
        if($this->item_id) {
            $query->andWhere(['item_id' => $this->item_id]);
        }
        if($this->name) {
            $query->andWhere(['like','name', $this->name]);
        }
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> [
                'defaultOrder' => ['id' => SORT_DESC]
            ]
        ]);
        return $dataProvider;
    }
    
    public function search($params) {
        $query = ShopItems::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> [
                'defaultOrder' => ['id' => SORT_DESC]
            ]
        ]);    
        $this->load($params);    
        if (!$this->validate()) {
            return $dataProvider;
        }    
        if($this->discount_end === '') $this->discount_end = null;
        $query->andFilterWhere([
            'type' => $this->type,
            'discount' => $this->discount,
            'discount_end' => $this->discount_end,
            'item_id' => $this->item_id,
            'cost' => $this->cost,
            'realm_id' => $this->realm_id,
            'category_id' => $this->category_id,
        ]);
        $query->andFilterWhere(['like', 'name', $this->name]);
        return $dataProvider;
    }
    
}
