<?php

namespace core\models\i18n;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%meta_i18n}}".
 *
 * @property integer $id
 * @property integer $language
 * @property string $title
 * @property string $keywords
 * @property string $description
 * @property integer $updated_at
 * @property integer $created_at
 * @property int $meta_id [int(11)]
 */
class MetaI18n extends ActiveRecord {

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
        return '{{%meta_i18n}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['meta_id','created_at','updated_at','language'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['keywords','description'], 'string']
        ];
    }

}