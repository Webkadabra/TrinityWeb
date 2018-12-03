<?php

namespace core\modules\forum\models\db;

use core\modules\forum\db\ActiveRecord;
use core\modules\forum\helpers\Helper;
use yii\helpers\HtmlPurifier;

/**
 * Content AR
 *
 * @property integer $id
 * @property string $name
 * @property string $topic
 * @property string $content
 */
class ContentActiveRecord extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%content}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['content', 'topic'], 'required'],
            [['content', 'topic'], 'string', 'min' => 1],
            ['topic', 'filter', 'filter' => function ($value) {
                return HtmlPurifier::process(trim($value));
            }],
            ['content', 'filter', 'filter' => function ($value) {
                return HtmlPurifier::process(trim($value), Helper::podiumPurifierConfig('full'));
            }],
        ];
    }
}
