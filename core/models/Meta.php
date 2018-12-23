<?php

namespace core\models;

use core\behaviors\MultilingualBehavior;
use core\models\i18n\MetaI18n;
use core\models\query\MetaQuery;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/** @noinspection PropertiesInspection */

/**
 * @property int $id [int(11)]
 * @property string $route [varchar(255)]
 * @property string $title [varchar(255)]
 * @property string $keywords
 * @property string $description
 * @property string $robots_index [enum('INDEX', 'NOINDEX')]
 * @property string $robots_follow [enum('FOLLOW', 'NOFOLLOW')]
 * @property int $updated_at [int(11)]
 * @property int $created_at [int(11)]
 */
class Meta extends ActiveRecord
{
    const INDEX = 'INDEX';
    const NOINDEX = 'NOINDEX';
    const FOLLOW = "FOLLOW";
    const NOFOLLOW = "NOFOLLOW";

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%meta}}';
    }

    /**
     * @return MetaQuery
     */
    public static function find()
    {
        return new MetaQuery(get_called_class());
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
            ],
            'ml' => [
                'class'           => MultilingualBehavior::class,
                'languages'       => Yii::$app->i18nHelper::getLocales(true),
                'langClassName'   => MetaI18n::class,
                'defaultLanguage' => Yii::$app->language,
                'langForeignKey'  => 'meta_id',
                'tableName'       => MetaI18n::tableName(),
                'abridge'         => false,
                'attributes'      => [
                    'title', 'keywords', 'description',
                ]
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['route'], 'required'],
            [['robots_follow'], 'in', 'range' => [
                Meta::FOLLOW,
                Meta::NOFOLLOW
            ]],
            [['robots_index'], 'in', 'range' => [
                Meta::INDEX,
                Meta::NOINDEX
            ]],
            [['title','keywords', 'description'],'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'route'         => Yii::t('core', 'Route'),
            'robots_follow' => Yii::t('core', 'Robots Follow'),
            'robots_index'  => Yii::t('core', 'Robots Index'),
        ];
    }
}