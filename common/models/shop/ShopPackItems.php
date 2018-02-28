<?php

namespace common\models\shop;

use Yii;

/**
 * This is the model class for table "web_shop_pack_items".
 *
 * @property integer $id
 * @property integer $shop_parent_item_id
 * @property integer $shop_item_id
 *
 * @property ShopItems $shopElement
 */
class ShopPackItems extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%shop_package_items}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['shop_item_id', 'shop_parent_item_id'], 'integer'],
            [['shop_item_id'], 'exist', 'skipOnError' => true, 'targetClass' => ShopItems::className(), 'targetAttribute' => ['shop_item_id' => 'id']],
        ];
    }

    public function afterSave($insert, $changedAttributes) {
        Yii::$app->cache->flush();
        parent::afterSave($insert, $changedAttributes);
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'shop_parent_item_id' => Yii::t('common', 'Внешний ключ'),
            'shop_item_id' => Yii::t('common', 'Товар/услуга'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRelationShopElement()
    {
        return $this->hasOne(ShopItems::className(), ['id' => 'shop_item_id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRelationShopPack() {
        return $this->hasOne(Shopitems::className(),['id' => 'shop_parent_item_id']);
    }
    
}