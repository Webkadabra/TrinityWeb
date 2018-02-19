<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "web_shop_category".
 *
 * @property int $id
 * @property int $root
 * @property int $lvl
 * @property string $icon
 * @property int $icon_type
 * @property int $active
 * @property int $visible
 * @property int $disabled
 * @property int $selected
 * @property int $readonly
 * @property int $collapsed
 * @property int $movable_d
 * @property int $movable_u
 * @property int $movable_l
 * @property int $movable_r
 * @property int $removable
 * @property int $removable_all
 * @property string $name
 * @property double $discount
 * @property int $lft
 * @property int $rgt
 * @property int $created_at
 * @property int $updated_at
 *
 * @property ShopItems[] $shopItems
 */
class ShopCategory extends \kartik\tree\models\Tree
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%shop_category}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['root', 'lvl', 'icon_type', 'active', 'visible', 'disabled', 'selected', 'readonly', 'collapsed', 'movable_d', 'movable_u', 'movable_l', 'movable_r', 'removable', 'removable_all', 'lft', 'rgt', 'created_at', 'updated_at'], 'integer'],
            [['name', 'lft', 'rgt', 'created_at', 'updated_at'], 'required'],
            [['discount'], 'number'],
            [['icon', 'name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'root' => Yii::t('common', 'Root'),
            'lvl' => Yii::t('common', 'Lvl'),
            'icon' => Yii::t('common', 'Icon'),
            'icon_type' => Yii::t('common', 'Icon Type'),
            'active' => Yii::t('common', 'Active'),
            'visible' => Yii::t('common', 'Visible'),
            'disabled' => Yii::t('common', 'Disabled'),
            'selected' => Yii::t('common', 'Selected'),
            'readonly' => Yii::t('common', 'Readonly'),
            'collapsed' => Yii::t('common', 'Collapsed'),
            'movable_d' => Yii::t('common', 'Movable D'),
            'movable_u' => Yii::t('common', 'Movable U'),
            'movable_l' => Yii::t('common', 'Movable L'),
            'movable_r' => Yii::t('common', 'Movable R'),
            'removable' => Yii::t('common', 'Removable'),
            'removable_all' => Yii::t('common', 'Removable All'),
            'name' => Yii::t('common', 'Name'),
            'discount' => Yii::t('common', 'Discount'),
            'lft' => Yii::t('common', 'Lft'),
            'rgt' => Yii::t('common', 'Rgt'),
            'created_at' => Yii::t('common', 'Created At'),
            'updated_at' => Yii::t('common', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRelationShopItems()
    {
        return $this->hasMany(ShopItems::className(), ['category_id' => 'id']);
    }
}
