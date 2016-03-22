<?php

namespace Kalnoy\Shopping\Widgets;

use Kalnoy\Shopping\Contracts\Widgets\Option as OptionContract;

/**
 * Class Select
 *
 * @package Kalnoy\Shopping\Filters\Widgets
 */
class Select extends AbstractOptionsWidget
{
    /**
     * Get the evaluated contents of the object.
     *
     * @return string
     */
    public function render()
    {
        $class = $this->getContainerClass();
        $name = $this->id;

        return '<select class="'.$class.'" name="'.$name.'">'.$this->renderItems().'</select>';
    }

    /**
     * @param OptionContract $option
     *
     * @return string
     */
    protected function renderItem(OptionContract $option)
    {
        $selected = $option ? ' selected="selected"' : '';

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
    protected function getBaseContainerClass()
    {
        return 'SelectFilter';
    }

}