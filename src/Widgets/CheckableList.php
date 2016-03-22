<?php

namespace Kalnoy\Shopping\Widgets;

use Illuminate\Contracts\Support\Renderable;
use Kalnoy\Shopping\Contracts\Widgets\Option as OptionContract;

/**
 * The widget that renders a list of options.
 */
class CheckableList extends AbstractOptionsList
{
    /**
     * @var string
     */
    public $itemTemplate = '<div class="{class}"><label>{option}{frequency}</label></div>';

    /**
     * @param OptionContract $option
     *
     * @return string
     */
    protected function renderOption(OptionContract $option)
    {
        $checked = $this->isActive($option) ? ' checked="checked"' : '';

        $filterId = $this->id;
        $id = $this->getInputId($option->getValue());
        $type = $this->getCheckableType();

        if ($this->multiple) {
            $filterId .= '[]';
        }

        $title = $this->renderTitle($option->getTitle());

        return '<input type="'.$type.'" value="'.$option->getValue().'" name="'.$filterId.'" id="'.$id.'" '.$checked.'> '.$title;
    }

    /**
     * @param string $value
     *
     * @return string
     */
    protected function renderTitle($value)
    {
        if ( ! $this->html) $value = e($value);

        return '<span class="title">'.$value.'</span>';
    }

    /**
     * @return string
     */
    protected function getCheckableType()
    {
        return $this->multiple ? 'checkbox' : 'radio';
    }

    /**
     * @inheritDoc
     */
    protected function getItemClass(OptionContract $option)
    {
        return parent::getItemClass($option).' '.$this->getCheckableType();
    }

    /**
     * @return string
     */
    protected function getBaseContainerClass()
    {
        return 'CheckableFilter';
    }

    /**
     * @param $key
     *
     * @return string
     */
    protected function getInputId($key)
    {
        return $this->id.'__'.$key;
    }
}