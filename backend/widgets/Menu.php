<?php

namespace backend\widgets;

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * Class Menu
 * @package backend\components\widget
 */
class Menu extends \yii\widgets\Menu
{

    public $submenuTemplate = "\n<ul id=\"{id}\" class=\"sidenav-second-level {collapsed}\">\n{items}\n</ul>\n";

    /**
     * @var string
     */
    public $linkTemplate = "<a href=\"{url}\" {data-toggle} class=\"{class}\"{aria-expanded}{aria-controls}{role}>\n{label}\n{badge}\n{icon}</a>";

    /**
     * @var string
     */
    public $labelTemplate = "<span class=\"nav-link\">{icon}\n{label}\n{badge}</span>";

    /**
     * @var string
     */
    public $badgeTag = 'span';
    /**
     * @var string
     */
    public $badgeClass = 'label pull-right';
    /**
     * @var string
     */
    public $badgeBgClass;

    /**
     * @inheritdoc
     */
    protected function renderItem($item)
    {
        $item['badgeOptions'] = isset($item['badgeOptions']) ? $item['badgeOptions'] : [];

        if (!ArrayHelper::getValue($item, 'badgeOptions.class')) {
            $bg = isset($item['badgeBgClass']) ? $item['badgeBgClass'] : $this->badgeBgClass;
            $item['badgeOptions']['class'] = $this->badgeClass . ' ' . $bg;
        }

        if (isset($item['url'])) {
            $template = ArrayHelper::getValue($item, 'template', $this->linkTemplate);
            return strtr($template, [
                '{badge}' => isset($item['badge'])
                    ? Html::tag(
                        'span',
                        Html::tag('small', $item['badge'], $item['badgeOptions']),
                        ['class' => 'pull-right-container']
                    )
                    : '',
                '{class}' => 'nav-link' . (!$item['active'] ? null : ' active') . (isset($item['linkOptions']) && $item['linkOptions']['class'] ? ' ' . $item['linkOptions']['class'] : ''),
                '{data-toggle}' => isset($item['items']) ? 'data-toggle="collapse" ':null,
                '{icon}' => isset($item['icon']) ? $item['icon'] : '',
                '{url}' => Url::to($item['url']),
                '{role}' => isset($item['items']) && $item['items'] ? ' role="button"' : null,
                '{aria-expanded}' => isset($item['items']) && $item['items'] ? $item['active'] ? ' aria-expanded="true"' : ' aria-expanded="false"' : null,
                '{aria-controls}' => isset($item['items']) && $item['items'] ? " aria-controls=\"".str_replace('#','',Url::to($item['url']))."\"" : null,
                '{label}' => $item['label'],
            ]);
        } else {
            $template = ArrayHelper::getValue($item, 'template', $this->labelTemplate);

            return strtr($template, [
                '{badge}' => isset($item['badge'])
                    ? Html::tag('small', $item['badge'], $item['badgeOptions'])
                    : '',
                '{icon}' => isset($item['icon']) ? $item['icon'] : '',
                '{label}' => $item['label'],
            ]);
        }
    }

    /**
     * Recursively renders the menu items (without the container tag).
     * @param array $items the menu items to be rendered recursively
     * @return string the rendering result
     */
    protected function renderItems($items)
    {
        $n = count($items);
        $lines = [];
        foreach ($items as $i => $item) {
            $options = array_merge($this->itemOptions, ArrayHelper::getValue($item, 'options', []));
            $tag = ArrayHelper::remove($options, 'tag', 'li');
            $class = [];

            if ($i === 0 && $this->firstItemCssClass !== null) {
                $class[] = $this->firstItemCssClass;
            }
            if ($i === $n - 1 && $this->lastItemCssClass !== null) {
                $class[] = $this->lastItemCssClass;
            }
            Html::addCssClass($options, $class);


            if (!empty($item['items'])) {

                $parent_id = isset($this->options['id']) ? $this->options['id'] : substr(md5(mt_rand()), 0, 7);
                $sub_id = substr(md5(mt_rand()), 0, 7);

                $item['url'] = '#' . $sub_id;
                $menu = $this->renderItem($item);

                $submenuTemplate = ArrayHelper::getValue($item, 'submenuTemplate', $this->submenuTemplate);
                $menu .= strtr($submenuTemplate, [
                    '{items}' => $this->renderItems($item['items']),
                    '{id}' => $sub_id,
                    '{collapsed}' => $item['active'] ? 'collapse show' : 'collapse',
                ]);
            } else {
                $menu = $this->renderItem($item);
            }
            $lines[] = Html::tag($tag, $menu, $options);
        }

        return implode("\n", $lines);
    }

}
