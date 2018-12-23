<?php

namespace core\modules\installer\helpers;

use unclead\multipleinput\renderers\ListRenderer;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * Class DatabaseRender
 */
class DatabaseRender extends ListRenderer
{
    /**
     * Renders the cell content.
     *
     * @param BaseColumn $column
     * @param int|null $index
     * @return string
     */
    public function renderCellContent($column, $index)
    {
        $id = $column->getElementId($index);
        $name = $column->getElementName($index);
        $input = $column->renderInput($name, [
            'id' => $id
        ]);

        if ($column->isHiddenInput()) {
            return $input;
        }

        $hasError = false;
        $error = '';
        $layoutConfig = array_merge([
            'offsetClass'  => 'col-sm-offset-3',
            'labelClass'   => 'col-sm-12',
            'wrapperClass' => 'col-sm-12',
            'errorClass'   => 'col-sm-offset-3 col-sm-6',
        ], $this->layoutConfig);

        Html::addCssClass($column->errorOptions, $layoutConfig['errorClass']);

        if ($index !== null) {
            $error = $column->getFirstError($index);
            $hasError = !empty($error);
        }

        $wrapperOptions = [
            'class' => 'field-' . $id
        ];

        if ($hasError) {
            Html::addCssClass($wrapperOptions, 'has-error');
        }

        Html::addCssClass($wrapperOptions, $layoutConfig['wrapperClass']);

        $content = Html::beginTag('div', [
            'class' => 'form-group list-cell__' . $column->name . ($hasError ? ' has-error' : '') . ' ' . $column->headerOptions['class']
        ]);

        if (empty($column->title)) {
            Html::addCssClass($wrapperOptions, $layoutConfig['offsetClass']);
        } else {
            $content .= Html::label($column->title, $id, [
                'class' => $layoutConfig['labelClass'] . ' control-label'
            ]);
        }

        $content .= Html::tag('div', $input, $wrapperOptions);

        if ($column->enableError) {
            $content .= "\n" . $column->renderError($error);
        }

        $content .= Html::endTag('div');

        return $content;
    }

    /**
     * Returns template for using in js.
     *
     * @throws \Exception
     * @return string
     */
    protected function prepareTemplate()
    {
        return $this->renderRowContent();
    }

    /**
     * Renders the body.
     *
     * @throws \Exception
     * @return string
     */
    protected function renderBody()
    {
        $rows = [];

        if ($this->data) {
            $cnt = count($this->data);
            if ($this->min === $this->max && $cnt < $this->max) {
                $cnt = $this->max;
            }

            $indices = array_keys($this->data);

            for ($i = 0; $i < $cnt; $i++) {
                $index = ArrayHelper::getValue($indices, $i, $i);
                $item = ArrayHelper::getValue($this->data, $index, null);
                $rows[] = $this->renderRowContent($index, $item);
            }
        } elseif ($this->min > 0) {
            for ($i = 0; $i < $this->min; $i++) {
                $rows[] = $this->renderRowContent($i);
            }
        }

        return Html::tag('tbody', implode("\n", $rows));
    }

    /**
     * Renders the row content.
     *
     * @param int $index
     * @param ActiveRecordInterface|array $item
     * @throws \Exception
     * @return mixed
     */
    private function renderRowContent($index = null, $item = null)
    {
        $elements = [];
        foreach ($this->columns as $column) {
            /* @var $column BaseColumn */
            $column->setModel($item);
            $elements[] = $this->renderCellContent($column, $index);
        }

        $content = [];
        $content[] = Html::tag('td', implode("\n", $elements), ['class' => 'row']);
        if ($this->max !== $this->min) {
            $content[] = $this->renderActionColumn($index);
        }

        if ($this->cloneButton) {
            $content[] = $this->renderCloneColumn();
        }

        $content = Html::tag('tr', implode("\n", $content), $this->prepareRowOptions($index, $item));

        if ($index !== null) {
            $content = str_replace('{' . $this->getIndexPlaceholder() . '}', $index, $content);
        }

        return $content;
    }

    /**
     * Renders the action column.
     *
     * @param null|int $index
     * @param null|ActiveRecordInterface|array $item
     * @throws \Exception
     * @return string
     */
    private function renderActionColumn($index = null, $item = null)
    {
        $content = $this->getActionButton($index) . $this->getExtraButtons($index, $item);

        return Html::tag('td', $content, [
            'class' => 'list-cell__button',
        ]);
    }

    private function getActionButton($index)
    {
        if ($index === null || $this->min === 0) {
            return $this->renderRemoveButton();
        }

        $index++;
        if ($index < $this->min) {
            return '';
        } elseif ($index === $this->min) {
            return $this->isAddButtonPositionRow() ? $this->renderAddButton() : '';
        }
  
            return $this->renderRemoveButton();
    }

    /**
     * Renders remove button.
     *
     * @throws \Exception
     * @return string
     */
    private function renderRemoveButton()
    {
        $options = [
            'class' => 'btn multiple-input-list__btn js-input-remove',
        ];
        Html::addCssClass($options, $this->removeButtonOptions['class']);

        return Html::tag('div', $this->removeButtonOptions['label'], $options);
    }

    /**
     * Renders clone button.
     *
     * @throws \Exception
     * @return string
     */
    private function renderCloneButton()
    {
        $options = [
            'class' => 'btn multiple-input-list__btn js-input-clone',
        ];
        Html::addCssClass($options, $this->cloneButtonOptions['class']);

        return Html::tag('div', $this->cloneButtonOptions['label'], $options);
    }

    private function renderAddButton()
    {
        $options = [
            'class' => 'btn multiple-input-list__btn js-input-plus',
        ];
        Html::addCssClass($options, $this->addButtonOptions['class']);

        return Html::tag('div', $this->addButtonOptions['label'], $options);
    }
}
