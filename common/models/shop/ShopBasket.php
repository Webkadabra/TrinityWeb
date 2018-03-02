<?php

namespace common\models\shop;

use Yii;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "web_shop_basket".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $item_id
 * @property integer $count
 */
class ShopBasket extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%shop_basket}}';
    }
    
    public function __construct($config = array()) {
        parent::__construct($config);
        $this->user_id = Yii::$app->user->getId();
        $this->count = 1;
    }
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'item_id'], 'required'],
            [['user_id', 'item_id','count'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => Yii::t('common', 'Пользователь'),
            'item_id' => Yii::t('common', 'Товар/услуга'),
            'count' => Yii::t('common', 'Кол-во'),
        ];
    }
    
    public function getRelationShopItem() {
        return $this->hasOne(ShopItems::className(),['id' => 'item_id']);
    }
}