<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%user_payment_history}}".
 *
 * @property int $id
 * @property int $merchant_id
 * @property int $user_id
 * @property int $amount
 * @property int $currency_id
 * @property string $sign
 * @property string $operation_data
 * @property string $operation_time_success
 * @property string $operation_time_complete
 * @property integer $statis
 */
class UserPaymentHistory extends \yii\db\ActiveRecord
{
    
    const STATUS_NEW = 0;
    const STATUS_COMPLETE = 10;
    const STATUS_SUCCESS = 5;
    const STATUS_FAIL = -1;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_payment_history}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['merchant_id', 'user_id', 'amount', 'currency_id', 'status', 'operation_time_success', 'operation_time_complete'], 'integer'],
            [['sign', 'operation_data'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'merchant_id' => 'Merchant ID',
            'user_id' => Yii::t('common', 'Пользователь'),
            'amount' => Yii::t('common', 'Стоимость'),
            'currency_id' => Yii::t('common', 'Валюта'),
            'sign' => 'Sign',
            'operation_data' => 'Operation Data',
            'operation_data' => Yii::t('common', 'Статус'),
            'operation_time_success' => Yii::t('common', 'Время подтверждения на сайте'),
            'operation_time_complete' => Yii::t('common', 'Время подтверждения оплаты'),
        ];
    }
}
