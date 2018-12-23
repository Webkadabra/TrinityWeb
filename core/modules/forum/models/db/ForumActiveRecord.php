<?php

namespace core\modules\forum\models\db;

use core\modules\forum\db\ActiveRecord;
use core\modules\forum\models\Category;
use core\modules\forum\models\Post;
use core\modules\forum\Podium;
use core\modules\forum\slugs\PodiumSluggableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\helpers\HtmlPurifier;

/**
 * Forum AR
 *
 * @property integer $id
 * @property integer $root
 * @property integer $lvl
 * @property integer $lft
 * @property integer $rgt
 * @property integer $category_id
 * @property string $name
 * @property string $sub
 * @property string $slug
 * @property string $keywords
 * @property string $description
 * @property string $icon
 * @property integer $icon_type
 * @property integer $visible
 * @property integer $sort
 * @property integer $updated_at
 * @property integer $created_at
 */
class ForumActiveRecord extends \kartik\tree\models\Tree
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%forum}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                TimestampBehavior::class,
                [
                    'class'     => Podium::getInstance()->slugGenerator,
                    'attribute' => 'name',
                    'type'      => PodiumSluggableBehavior::FORUM
                ]
            ]
        );
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_merge(
            parent::rules(),
            [
                [['name', 'visible'], 'required'],
                ['visible', 'boolean'],
                [['name', 'sub'], 'filter', 'filter' => function ($value) {
                    return HtmlPurifier::process(trim($value));
                }],
                [['keywords', 'description'], 'string'],
                [['category_id'],'safe'],
            ]
        );
    }

    /**
     * Category relation.
     * @return ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }

    /**
     * Post relation. One latest post.
     * @return ActiveQuery
     */
    public function getLatest()
    {
        return $this->hasOne(Post::class, ['forum_id' => 'id'])->orderBy(['id' => SORT_DESC]);
    }

    /**
     * Parent relation.
     * @return ActiveQuery
     */
    public function getParent() {
        return $this->hasOne(self::class, ['id' => 'root'])->andWhere(['lvl' => (($this->lvl - 1) >= 0 ? 0 : ($this->lvl - 1))]);
    }

    /**
     * Post relation. One latest post.
     * @return array|Post|null|\yii\db\ActiveRecord
     */
    public function findLatestPost() {
        $forum_ids = [$this->id];
        $childs = $this->children()->all();
        foreach($childs as $child) {
            $forum_ids[] = $child->id;
        }

        return Post::find()->where(['forum_id' => $forum_ids])->orderBy(['id' => SORT_DESC])->one();
    }
}
