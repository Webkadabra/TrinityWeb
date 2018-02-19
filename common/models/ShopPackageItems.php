<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "web_shop_package_items".
 *
 * @property int $id
 * @property int $shop_parent_item_id
 * @property int $shop_item_id
 *
 * @property ShopItems $shopItem
 * @property ShopItems $shopParentItem
 */
class ShopPackageItems extends \yii\db\ActiveRecord
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
            [['shop_parent_item_id', 'shop_item_id'], 'integer'],
            [['shop_item_id'], 'exist', 'skipOnError' => true, 'targetClass' => ShopItems::className(), 'targetAttribute' => ['shop_item_id' => 'id']],
            [['shop_parent_item_id'], 'exist', 'skipOnError' => true, 'targetClass' => ShopItems::className(), 'targetAttribute' => ['shop_parent_item_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'shop_parent_item_id' => Yii::t('common', 'Shop Parent Item ID'),
            'shop_item_id' => Yii::t('common', 'Shop Item ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getShopItem()
    {
        return $this->hasOne(ShopItems::className(), ['id' => 'shop_item_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getShopParentItem()
    {
        return $this->hasOne(ShopItems::className(), ['id' => 'shop_parent_item_id']);
    }
}
