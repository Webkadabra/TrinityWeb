<?php

namespace core\widgets;

use cheatsheet\Time;
use core\models\WidgetCarousel;
use core\models\WidgetCarouselItem;
use Yii;
use yii\base\InvalidConfigException;
use yii\bootstrap\Carousel;
use yii\di\Instance;
use yii\helpers\Html;
use yii\web\AssetManager;

/**
 * Class DbCarousel
 * @package core\widgets
 */
class DbCarousel extends Carousel
{
    /**
     * @var
     */
    public $key;

    /**
     * @var string|array|callable|AssetManager
     */
    public $assetManager;

    /**
     * @var array
     */
    public $controls = [
        '<span class="glyphicon glyphicon-chevron-left"></span>',
        '<span class="glyphicon glyphicon-chevron-right"></span>',
    ];

    /**
     * @throws InvalidConfigException
     */
    public function init()
    {
        if (!$this->key) {
            throw new InvalidConfigException("key should be set");
        }
        $this->assetManager = Instance::ensure($this->assetManager, AssetManager::class);
        $cacheKey = [
            WidgetCarousel::class,
            $this->key
        ];
        $items = Yii::$app->cache->get($cacheKey);
        if ($items === false) {
            $items = [];
            $query = WidgetCarouselItem::find()
                ->joinWith('carousel')
                ->where([
                    '{{%widget_carousel_item}}.status' => 1,
                    '{{%widget_carousel}}.status'      => WidgetCarousel::STATUS_ACTIVE,
                    '{{%widget_carousel}}.key'         => $this->key,
                ])
                ->orderBy(['order' => SORT_ASC]);
            foreach ($query->all() as $k => $item) {
                /** @var $item \core\models\WidgetCarouselItem */
                if ($item->path) {
                    $url = $this->publishItem($item);
                    $items[$k]['content'] = Html::img($url, ['class' => 'w-100']);
                }

                if ($item->url) {
                    $items[$k]['content'] = Html::a($items[$k]['content'], $item->url, ['target' => '_blank']);
                }

                if ($item->caption) {
                    $items[$k]['caption'] = $item->caption;
                }
            }
            Yii::$app->cache->set($cacheKey, $items, Time::SECONDS_IN_A_YEAR);
        }
        $this->items = $items;
        parent::init();
    }

    public function renderProcessBar() {
        return '<hr class="transition-timer-carousel-progress-bar" />';
    }

    /**
     * Renders the widget.
     */
    public function run()
    {
        $this->registerPlugin('carousel');
        $content = '';
        if (!empty($this->items)) {
            $content = implode("\n", [
                $this->renderIndicators(),
                $this->renderItems(),
                $this->renderControls(),
                $this->renderProcessBar()
            ]);
        }

        return Html::tag('div', $content, $this->options);
    }

    /**
     * Renders carousel items as specified on [[items]].
     * @throws InvalidConfigException
     * @return string the rendering result
     */
    public function renderItems()
    {
        $items = [];
        for ($i = 0, $count = count($this->items); $i < $count; $i++) {
            $items[] = $this->renderItem($this->items[$i], $i);
        }

        return Html::tag('div', implode("\n", $items), ['class' => 'carousel-inner', 'role' => 'listbox']);
    }

    /**
     * Renders previous and next control buttons.
     * @throws InvalidConfigException if [[controls]] is invalid.
     */
    public function renderControls()
    {
        if (isset($this->controls[0], $this->controls[1])) {
            return Html::a($this->controls[0], '#' . $this->options['id'], [
                    'class'      => 'carousel-control-prev',
                    'data-slide' => 'prev',
                ]) . "\n"
                . Html::a($this->controls[1], '#' . $this->options['id'], [
                    'class'      => 'carousel-control-next',
                    'data-slide' => 'next',
                ]);
        } elseif ($this->controls === false) {
            return '';
        }  
            throw new InvalidConfigException('The "controls" property must be either false or an array of two elements.');
    }

    /**
     * @param WidgetCarouselItem $item
     *
     * @return string
     */
    protected function publishItem($item)
    {
        return $item->base_url . '/' . $item->path;
    }
}
