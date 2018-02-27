<?php

namespace common\models\shop;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "web_shop_category".
 *
 * @property integer $id
 * @property integer $root
 * @property integer $lvl
 * @property string $icon
 * @property integer $icon_type
 * @property integer $active
 * @property integer $visible
 * @property integer $disabled
 * @property integer $selected
 * @property integer $readonly
 * @property integer $collapsed
 * @property integer $movable_d
 * @property integer $movable_u
 * @property integer $movable_l
 * @property integer $movable_r
 * @property integer $removable
 * @property integer $removable_all
 * @property string $name
 * @property double $discount
 * @property string $discount_end
 * @property integer $lft
 * @property integer $rgt
 * @property integer $created_at
 * @property integer $updated_at
 *
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
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                TimestampBehavior::className(),
            ]
        );
    }
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['root', 'lvl', 'icon_type', 'active', 'visible', 'disabled', 'selected', 'readonly', 'collapsed', 'movable_d', 'movable_u', 'movable_l', 'movable_r', 'removable', 'removable_all', 'lft', 'rgt', 'created_at', 'updated_at'], 'integer'],
            [['name'], 'required'],
            [['discount'], 'number'],
            [['icon', 'name'], 'string', 'max' => 255],
            [['discount_end'],'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'root' => 'Root',
            'lvl' => 'Lvl',
            'icon' => 'Icon',
            'icon_type' => 'Icon Type',
            'active' => 'Active',
            'visible' => 'Visible',
            'disabled' => 'Disabled',
            'selected' => 'Selected',
            'readonly' => 'Readonly',
            'collapsed' => 'Collapsed',
            'movable_d' => 'Movable D',
            'movable_u' => 'Movable U',
            'movable_l' => 'Movable L',
            'movable_r' => 'Movable R',
            'removable' => 'Removable',
            'removable_all' => 'Removable All',
            'name' => Yii::t('common', 'Наименование категории'),
            'discount' => Yii::t('common', '% скидки'),
            'discount_end' => Yii::t('common', 'Окончание скидки'),
            'lft' => 'Lft',
            'rgt' => 'Rgt',
            'created_at' => Yii::t('common', 'Создан'),
            'updated_at' => Yii::t('common', 'Изменён'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRelationShopItems()
    {
        return $this->hasMany(ShopItems::className(), ['category_id' => 'id']);
    }
    
    public function getChilds() {
        return $this->children($this->lvl === 0 ? $this->lvl + 1 : $this->lvl);
    }
    
    public function generateShopMenu($activeCategory = null, $parentModel = null,$baseRootModel = null) {
        
        $cid = Yii::$app->request->get('cid');
        
        if($cid && $activeCategory === null) {
            $activeCategory = self::findOne($cid);
        }
        
        if(!$parentModel) {
            $models = self::find()->where(['lvl' => 0])->orderBy(['lft' => SORT_ASC])->all();
        } else {
            $models = $parentModel->getChilds()->all();
        }
        
        $items = [];
        
        
        foreach($models as $model) {
            
            if($baseRootModel === null) $baseRootModel = $model;
            $childs_array = self::generateShopMenu($activeCategory, $model, $baseRootModel);

            $is_opened = false;
            
            if($activeCategory) {
                if($activeCategory->id == $model->id) {
                    $is_opened = true;
                } else {
                    if($activeCategory->isChildOf($model)) {
                        $is_opened = true;
                    }
                }
            }
            
            $items[$model->id] = [
                'label' => Yii::t('common', $model->name),
                'url' => ['index','cid' => $model->id],
                'items' => $childs_array ? $childs_array : [],
                'active' => $is_opened,
            ];
        }
        return $items;
    }
    
    public static function buildBreadCrumbs() {
        
        $cid = Yii::$app->request->get('cid');
        
        if($cid) {
            $activeCategory = self::findOne($cid);
            
            $parents = $activeCategory->parents()->asArray()->all();
            
            foreach($parents as $parent) {
                Yii::$app->params['breadcrumbs'][] = [
                    'label' => Yii::t('common',$parent['name']),
                    'url' => ['/store/main/index','cid' => $parent['id']],
                ];
            }
            
            Yii::$app->params['breadcrumbs'][] = [
                'label' => Yii::t('common',$activeCategory->name),
            ];
            
        }
    }
    
}