<?php

namespace core\models\i18n;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%page_i18n}}".
 *
 * @property integer $id
 * @property integer $page_id
 * @property integer $language
 * @property string $title
 * @property string $body
 * @property integer $updated_at
 * @property integer $created_at
 */
class PageI18n extends ActiveRecord {
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%page_i18n}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['page_id','created_at','updated_at','language'], 'integer'],
            [['title'], 'string', 'max' => 512],
            [['body'], 'string']
        ];
    }
}