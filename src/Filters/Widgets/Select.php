<?php

namespace Kalnoy\Shopping\Filters\Widgets;

use Kalnoy\Shopping\Filters\Widgets\Options\Option;

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
     * @param Option $option
     *
     * @return string
     */
    protected function renderItem(Option $option)
    {
        $selected = $option ? ' selected="selected"' : '';

        $content = e($option->title);

        if ($this->shouldRenderFrequency($option->frequency)) {
            $content .= $this->renderFrequency($option->frequency);
        }

        return '<option value="'.e($option->value).'"'.$selected.'>'.$content.'</option>';
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