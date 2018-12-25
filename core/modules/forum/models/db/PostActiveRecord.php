<?php

namespace core\modules\forum\models\db;

use core\modules\forum\db\ActiveRecord;
use core\modules\forum\helpers\Helper;
use core\modules\forum\models\Forum;
use core\modules\forum\models\PostThumb;
use core\modules\forum\models\Thread;
use core\modules\forum\models\User;
use core\modules\forum\Podium;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\helpers\HtmlPurifier;

/**
 * Post model
 *
 * @property integer $id
 * @property string $content
 * @property integer $thread_id
 * @property integer $forum_id
 * @property integer $author_id
 * @property integer $likes
 * @property integer $dislikes
 * @property integer $updated_at
 * @property integer $created_at
 */
class PostActiveRecord extends ActiveRecord
{
    /**
     * @var bool Subscription flag.
     */
    public $subscribe;

    /**
     * @var string Topic.
     */
    public $topic;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%post}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [TimestampBehavior::class];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['topic', 'required', 'message' => Yii::t('podium/view', 'Topic can not be blank.'), 'on' => ['firstPost']],
            ['topic', 'filter', 'filter' => function ($value) {
                return HtmlPurifier::process(trim($value));
            }, 'on' => ['firstPost']],
            ['subscribe', 'boolean'],
            ['content', 'required'],
            ['content', 'filter', 'filter' => function ($value) {
                if (Podium::getInstance()->podiumConfig->get('forum.use_wysiwyg') === '0') {
                    return HtmlPurifier::process(trim($value), Helper::podiumPurifierConfig('markdown'));
                }

                return HtmlPurifier::process(trim($value), Helper::podiumPurifierConfig('full'));
            }],
            ['content', 'string', 'min' => 10],
        ];
    }

    /**
     * Author relation.
     * @return ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(User::class, ['id' => 'author_id']);
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
     * Forum relation.
     * @return ActiveQuery
     */
    public function getForum()
    {
        return $this->hasOne(Forum::class, ['id' => 'forum_id']);
    }

    /**
     * Thumbs relation.
     * @return ActiveQuery
     */
    public function getThumb()
    {
        return $this->hasOne(PostThumb::class, ['post_id' => 'id'])->where(['user_id' => User::loggedId()]);
    }
}
