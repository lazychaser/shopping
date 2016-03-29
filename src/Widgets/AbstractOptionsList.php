<?php

namespace Kalnoy\Shopping\Widgets;

use Kalnoy\Shopping\Contracts\Widgets\Option as OptionContract;

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
    public $html = false;

    /**
     * @param bool $value
     *
     * @return $this
     */
    public function html($value = true)
    {
        $this->html = $value;
        
        return $this;
    }

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
     * @param OptionContract $option
     *
     * @return string
     */
    protected function renderItem(OptionContract $option)
    {
        $class = $this->getItemClass($option);

        $frequency = $this->shouldRenderFrequency($option->getFrequency())
            ? $this->renderFrequency($option->getFrequency())
            : '';

        $option = $this->renderOption($option);

        return $this->renderTemplate($this->itemTemplate,
                                     compact('option', 'class', 'frequency'));
    }

    /**
     * @param OptionContract $option
     *
     * @return string
     */
    abstract protected function renderOption(OptionContract $option);

    /**
     * @param OptionContract $option
     *
     * @return array
     */
    protected function getItemClasses(OptionContract $option)
    {
        $classes = [ $this->getBaseItemClass() ];

        if ( ! is_null($option->getValue())) {
            $classes[] = $this->getValueClass($option->getValue());
        }

        if ($option->getFrequency() === 0) {
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
     * @param OptionContract $option
     *
     * @return string
     */
    public function getItemClass(OptionContract $option)
    {
        return implode(' ', $this->getItemClasses($option));
    }

    /**
     * @return string
     */
    public function getActiveClass()
    {
        return $this->getBaseItemClass().'--'.$this->activeClass;
    }

    /**
     * @return string
     */
    public function getMutedClass()
    {
        return $this->getBaseItemClass().'--'.$this->mutedClass;
    }

    /**
     * @param $value
     *
     * @return string
     */
    public function getValueClass($value)
    {
        return 'value__'.$value;
    }

}