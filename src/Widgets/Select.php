<?php

namespace Lazychaser\Shopping\Widgets;

use Lazychaser\Shopping\Contracts\Widgets\Option as OptionContract;

/**
 * Class Select
 *
 * @package Lazychaser\Shopping\Filters\Widgets
 */
class Select extends AbstractOptionsWidget
{
    /**
     * @var bool
     */
    public $multiple = false;

    /**
     * Get the evaluated contents of the object.
     *
     * @return string
     */
    public function render()
    {
        $class = $this->getContainerClass();
        $name = $this->id;
        $multiple = $this->multiple ? ' multiple="multiple"' : '';

        return '<select class="'.$class.'" name="'.$name.'"'.$multiple.'>'.$this->renderItems().'</select>';
    }

    /**
     * @param OptionContract $option
     *
     * @return string
     */
    protected function renderItem(OptionContract $option)
    {
        $selected = $this->isActive($option) ? ' selected="selected"' : '';

        $content = e($option->getTitle());

        if ($this->shouldRenderFrequency($option->getFrequency())) {
            $content .= $this->renderFrequency($option->getFrequency());
        }

        return '<option value="'.e($option->getValue()).'"'.$selected.'>'.$content.'</option>';
    }

    /**
     * @param $frequency
     *
     * @return string
     */
    protected function renderFrequency($frequency)
    {
        return $frequency ? ' ['.$frequency.']' : '';
    }

    /**
     * @return string
     */
    public function getBaseContainerClass()
    {
        return 'SelectFilter';
    }

}