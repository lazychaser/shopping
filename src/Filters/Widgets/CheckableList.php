<?php

namespace Kalnoy\Shopping\Filters\Widgets;

use Illuminate\Contracts\Support\Renderable;
use Kalnoy\Shopping\Filters\Filters\OptionalFilter;
use Kalnoy\Shopping\Contracts\Filters\OptionsProvider;
use Kalnoy\Shopping\Filters\Widgets\Options\Option;

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
     * @param Option $option
     *
     * @return string
     */
    protected function renderOption(Option $option)
    {
        $checked = $this->isActive($option) ? ' checked="checked"' : '';

        $filterId = $this->id;
        $id = $this->getInputId($option->value);
        $type = $this->getCheckableType();

        if ($this->multiple) {
            $filterId .= '[]';
        }

        $title = $this->renderTitle($option->title);

        return '<input type="'.$type.'" value="'.$option->value.'" name="'.$filterId.'" id="'.$id.'" '.$checked.'> '.$title;
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
    protected function getItemClass(Option $option)
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