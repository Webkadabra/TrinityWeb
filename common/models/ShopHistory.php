<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%shop_history}}".
 *
 * @property int $id
 * @property int $user_id
 * @property int $realm_id
 * @property int $character_id
 * @property int $is_gift
 * @property string $operation_data
 * @property int $operation_time
 * @property int $operation_cost
 */
class ShopHistory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%shop_history}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'realm_id', 'character_id', 'operation_data', 'operation_time'], 'required'],
            [['user_id', 'realm_id', 'character_id', 'is_gift', 'operation_time', 'operation_cost'], 'integer'],
            [['operation_data'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'user_id' => Yii::t('common', 'User ID'),
            'realm_id' => Yii::t('common', 'Realm ID'),
            'character_id' => Yii::t('common', 'Character ID'),
            'is_gift' => Yii::t('common', 'Is Gift'),
            'operation_data' => Yii::t('common', 'Operation Data'),
            'operation_time' => Yii::t('common', 'Operation Time'),
            'operation_cost' => Yii::t('common', 'Operation Cost'),
        ];
    }
    
    public function getUser() {
        return $this->hasOne(User::className(),['id' => 'user_id']);
    }
    
}
