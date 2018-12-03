<?php

namespace core\modules\forum\models\db;

use core\modules\forum\db\ActiveRecord;
use core\modules\forum\models\Post;
use core\modules\forum\models\Thread;
use yii\db\ActiveQuery;
use yii\helpers\HtmlPurifier;

/**
 * Vocabulary AR
 */
class VocabularyActiveRecord extends ActiveRecord
{
    /**
     * @var string Query
     */
    public $query;

    /**
     * @var int
     */
    public $thread_id;

    /**
     * @var int
     */
    public $post_id;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%vocabulary}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['query', 'string'],
            ['query', 'filter', 'filter' => function ($value) {
                return HtmlPurifier::process(trim($value));
            }],
        ];
    }

    /**
     * Thread relation.
     * @return ActiveQuery
     */
    public function getThread()
    {
        return $this->hasOne(Thread::class, ['id' => 'thread_id']);
    }

    /**
     * Post relation.
     * @return ActiveQuery
     */
    public function getPostData()
    {
        return $this->hasOne(Post::class, ['id' => 'post_id']);
    }

    /**
     * Posts relation via junction.
     * @return ActiveQuery
     */
    public function getPosts()
    {
        return $this->hasMany(Post::class, ['id' => 'post_id'])->viaTable('{{%vocabulary_junction}}', ['word_id' => 'id']);
    }
}
