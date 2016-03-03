<?php

namespace Kalnoy\Shopping\Filters\Widgets;

use Kalnoy\Shopping\Filters\Widgets\Options\Option;

abstract class AbstractOptionsList extends AbstractOptionsWidget
{
    /**
     * @var string
     */
    public $mutedClass = 'disabled';

    /**
     * @var string
     */
    public $activeClass = 'active';

    /**
     * @var string
     */
    public $itemTemplate = '<li class="{class}">{option}{frequency}</li>';

    /**
     * @var string
     */
    public $template = '<ul class="{class}">{items}</ul>';

    /**
     * Whether to allow html for option label.
     * 
     * @var bool
     */
    public $html = true;

    /**
     * @return string
     */
    public function render()
    {
        $items = $this->renderItems();
        $class = $this->getContainerClass();

        return $this->renderTemplate($this->template, compact('items', 'class'));
    }

    /**
     * @param Option $option
     *
     * @return string
     */
    protected function renderItem(Option $option)
    {
        $class = $this->getItemClass($option);
        
        $frequency = $this->shouldRenderFrequency($option->frequency)
            ? $this->renderFrequency($option->frequency) 
            : '';
        
        $option = $this->renderOption($option);

        return $this->renderTemplate($this->itemTemplate,
                                     compact('option', 'class', 'frequency'));
    }

    /**
     * @param Option $option
     *
     * @return string
     */
    abstract protected function renderOption(Option $option);

    /**
     * @param Option $option
     *
     * @return array
     */
    protected function getItemClasses(Option $option)
    {
        $classes = [ $this->getBaseItemClass() ];

        if ( ! is_null($option->value)) {
            $classes[] = $this->getValueClass($option->value);
        }

        if ($option->frequency === 0) {
            $classes[] = $this->getMutedClass();
        }

        if ($this->isActive($option)) {
            $classes[] = $this->getActiveClass();
        }

        return $classes;
    }

    /**
     * @return string
     */
    protected function getBaseItemClass()
    {
        return $this->getBaseContainerClass().'__item';
    }

    /**
     * @param Option $option
     *
     * @return string
     */
    protected function getItemClass(Option $option)
    {
        return implode(' ', $this->getItemClasses($option));
    }

    /**
     * @param Option $option
     *
     * @return bool
     */
    protected function isActive(Option $option)
    {
        if ($option->active !== null) {
            return $option->active;
        }

        $input = \Input::get($this->id);
        $value = $option->value;

        return is_array($input) ? in_array($value, $input) : $value == $input;
    }

    /**
     * @return string
     */
    protected function getActiveClass()
    {
        return $this->getBaseItemClass().'--'.$this->activeClass;
    }

    /**
     * @return string
     */
    protected function getMutedClass()
    {
        return $this->getBaseItemClass().'--'.$this->mutedClass;
    }

    /**
     * @param $value
     *
     * @return string
     */
    protected function getValueClass($value)
    {
        return 'value__'.$value;
    }

}