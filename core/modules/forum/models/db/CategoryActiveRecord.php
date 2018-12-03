<?php

namespace core\modules\forum\models\db;

use core\modules\forum\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\helpers\HtmlPurifier;
use core\modules\forum\Podium;
use core\modules\forum\slugs\PodiumSluggableBehavior;

/**
 * Category model
 *
 * @property integer $id
 * @property string $name
 * @property string $slug
 * @property string $keywords
 * @property string $description
 * @property integer $visible
 * @property integer $locked
 * @property integer $sort
 * @property integer $updated_at
 * @property integer $created_at
 */
class CategoryActiveRecord extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%forum_category}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            [
                'class' => Podium::getInstance()->slugGenerator,
                'attribute' => 'name',
                'type' => PodiumSluggableBehavior::CATEGORY
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'visible'], 'required'],
            [['visible','locked'], 'boolean'],
            ['name', 'filter', 'filter' => function ($value) {
                return HtmlPurifier::process(trim($value));
            }],
            [['keywords', 'description'], 'string'],
        ];
    }
}
