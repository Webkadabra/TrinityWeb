<?php

namespace core\modules\forum\services;

use core\modules\forum\models\Category;
use core\modules\forum\models\Forum;
use core\modules\forum\models\Thread;
use core\modules\forum\Podium;
use yii\base\Component;

/**
 * Thread Verifier
 */
class ThreadVerifier extends Component
{
    /**
     * @var int category ID
     */
    public $categoryId;

    /**
     * @var int forum ID
     */
    public $forumId;

    /**
     * @var int thread ID
     */
    public $threadId;

    /**
     * @var string thread slug
     */
    public $threadSlug;

    private $_query;

    /**
     * Validates parameters.
     * @return bool
     */
    public function validate()
    {
        if (is_numeric($this->categoryId) && $this->categoryId >= 1
                && is_numeric($this->forumId) && $this->forumId >= 1
                && is_numeric($this->threadId) && $this->threadId >= 1
                && !empty($this->threadSlug)) {
            return true;
        }

        return false;
    }

    /**
     * Returns verified thread.
     * @return Thread
     */
    public function verify()
    {
        if (!$this->validate()) {
            return null;
        }
        $this->_query = Thread::find()->where([
                            Thread::tableName() . '.id'          => $this->threadId,
                            Thread::tableName() . '.slug'        => $this->threadSlug,
                            Thread::tableName() . '.forum_id'    => $this->forumId,
                            Thread::tableName() . '.category_id' => $this->categoryId,
                        ]);
        if (Podium::getInstance()->user->isGuest) {
            return $this->getThreadForGuests();
        }

        return $this->getThreadForMembers();
    }

    /**
     * Returns thread for guests.
     * @return Thread
     */
    protected function getThreadForGuests()
    {
        return $this->_query->joinWith([
                'forum' => function ($query) {
                    $query->andWhere([
                            Forum::tableName() . '.visible' => 1
                        ])->joinWith(['category'            => function ($query) {
                            $query->andWhere([Category::tableName() . '.visible' => 1]);
                        }]);
                }
            ])->limit(1)->one();
    }

    /**
     * Returns thread for members.
     * @return Thread
     */
    protected function getThreadForMembers()
    {
        return $this->_query->joinWith('forum.category')->limit(1)->one();
    }
}
