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
            [['discount_end'], 'safe'],
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
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getShopBaskets()
    {
        return $this->hasMany(ShopBasket::className(), ['item_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(ShopCategory::className(), ['id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getShopPackageItems()
    {
        return $this->hasMany(ShopPackageItems::className(), ['shop_item_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getShopPackageItems0()
    {
        return $this->hasMany(ShopPackageItems::className(), ['shop_parent_item_id' => 'id']);
    }
}
