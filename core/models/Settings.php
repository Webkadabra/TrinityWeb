<?php

namespace core\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * @property integer $key
 * @property integer $value
 * @property string $comment
 * @property int $updated_at [int(11)]
 * @property int $created_at [int(11)]
 */
class Settings extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%settings}}';
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['key', 'value'], 'required'],
            [['key'], 'string', 'max' => 128],
            [['value', 'comment'], 'safe'],
            [['key'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'key' => Yii::t('common', 'Key'),
            'value' => Yii::t('common', 'Value'),
            'comment' => Yii::t('common', 'Comment'),
        ];
    }
}