<?php

namespace core\modules\forum\models;

use core\modules\forum\models\db\VocabularyActiveRecord;
use core\modules\forum\Podium;
use yii\data\ActiveDataProvider;

/**
 * Vocabulary model
 * Automatic tag words from posts.
 */
class Vocabulary extends VocabularyActiveRecord
{
    /**
     * Returns data provider for simple search.
     * @return ActiveDataProvider
     */
    public function search()
    {
        $query = static::find()->where(['and',
            ['is not', 'post_id', null],
            ['like', 'word', $this->query]
        ])->joinWith(['posts.author', 'posts.thread']);
        if (Podium::getInstance()->user->isGuest) {
            $query->joinWith(['posts.forum' => function($q) {
                $q->where([Forum::tableName() . '.visible' => 1]);
            }]);
        }
        $query->groupBy(['post_id', 'word_id']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['thread_id' => SORT_DESC],
                'attributes' => [
                    'thread_id' => [
                        'asc' => ['thread_id' => SORT_ASC],
                        'desc' => ['thread_id' => SORT_DESC],
                        'default' => SORT_DESC,
                    ],
                ]
            ],
        ]);

        return $dataProvider;
    }
}
