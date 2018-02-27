<?php

namespace common\models\shop;

use Yii;

/**
 * This is the model class for table "{{%shop_history}}".
 *
 * @property int $id
 * @property int $user_id
 * @property int $realm_id
 * @property int $character_id
 * @property int $is_gift
 * @property integer $operation_cur
 * @property integer $operation_status
 * @property string $operation_data
 * @property string $operation_desc
 * @property string $operation_sign
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
            'id' => 'ID',
            'user_id' => Yii::t('common', 'Пользователь'),
            'realm_id' => Yii::t('common', 'Сервер'),
            'character_id' => Yii::t('common', 'Персонаж'),
            'is_gift' => Yii::t('common', 'Подарок ?'),
            'operation_data' => Yii::t('common', 'Дата операции'),
            'operation_time' => Yii::t('common', 'Время операции'),
            'operation_cost' => Yii::t('common', 'Итоговая стоимость'),
        ];
    }
    
    public function getUser() {
        return $this->hasOne(User::className(),['id' => 'user_id']);
    }
    
}
