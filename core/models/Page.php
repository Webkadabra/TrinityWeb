<?php

namespace core\models;

use core\behaviors\MultilingualBehavior;
use core\models\i18n\PageI18n;
use core\models\query\PageQuery;
use Yii;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/** @noinspection PropertiesInspection */

/**
 * This is the model class for table "{{%page}}".
 *
 * @property integer $id
 * @property string $slug
 * @property string $view
 * @property string $title
 * @property string $body
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 */
class Page extends ActiveRecord
{
    const STATUS_DRAFT = 0;
    const STATUS_PUBLISHED = 1;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%page}}';
    }

    /**
     * @return PageQuery
     */
    public static function find()
    {
        return new PageQuery(get_called_class());
    }

    /**
     * @return array statuses list
     */
    public static function statuses()
    {
        return [
            self::STATUS_DRAFT     => Yii::t('common', 'Draft'),
            self::STATUS_PUBLISHED => Yii::t('common', 'Published'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            'ml' => [
                'class'           => MultilingualBehavior::class,
                'languages'       => Yii::$app->i18nHelper::getLocales(true),
                'langClassName'   => PageI18n::class,
                'defaultLanguage' => Yii::$app->language,
                'langForeignKey'  => 'page_id',
                'tableName'       => PageI18n::tableName(),
                'abridge'         => false,
                'attributes'      => [
                    'title', 'body',
                ]
            ],
            'slug' => [
                'class'        => SluggableBehavior::class,
                'attribute'    => "title",
                'ensureUnique' => true,
                'immutable'    => true
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status'], 'integer'],
            [['slug'], 'unique'],
            [['slug'], 'string', 'max' => 2048],
            [['view'], 'string', 'max' => 255],
            [['title','body'],'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'         => Yii::t('common', 'ID'),
            'slug'       => Yii::t('common', 'Slug'),
            'view'       => Yii::t('common', 'Page View'),
            'status'     => Yii::t('common', 'Active'),
            'created_at' => Yii::t('common', 'Created At'),
            'updated_at' => Yii::t('common', 'Updated At'),
        ];
    }
}