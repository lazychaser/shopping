<?php

namespace Kalnoy\Shopping\Filters\Widgets;

use Kalnoy\Shopping\Filters\Filters\OptionalFilter;
use Kalnoy\Shopping\Contracts\Filters\OptionsProvider;
use Kalnoy\Shopping\Filters\Widgets\Options\Option;
use Kalnoy\Shopping\Filters\Widgets\Options\OptionsBuilder;

abstract class AbstractOptionsWidget extends AbstractControlWidget
{
    /**
     * The list of options.
     *
     * @var array
     */
    public $items = [ ];

    /**
     * @var bool
     */
    public $frequency = true;

    /**
     * @var bool
     */
    public $multiple = true;

    /**
     * @return string
     */
    protected function renderItems()
    {
        $html = '';

        foreach ($this->getArrayableItems() as $item) {
            if (is_array($item)) {
                $item = Option::fromArray($item);
            }

            $html .= $this->renderItem($item);
        }

        return $html;
    }

    /**
     * @param Option $option
     *
     * @return string
     */
    abstract protected function renderItem(Option $option);

    /**
     * @param $frequency
     *
     * @return string
     */
    protected function renderFrequency($frequency)
    {
        return $frequency
            ? '<span class="frequency">'.$frequency.'</span>'
            : '';
    }

    /**
     * @return array
     */
    private function getArrayableItems()
    {
        if ($this->items instanceof OptionsBuilder) {
            $this->items = $this->items->options();
        }

        return $this->items;
    }

    /**
     * @return string
     */
    protected function getContainerClass()
    {
        return $this->getBaseContainerClass().' '.
               $this->getContainerUniqueClass();
    }

    /**
     * @return string
     */
    abstract protected function getBaseContainerClass();

    /**
     * @param $frequency
     *
     * @return bool
     */
    protected function shouldRenderFrequency($frequency)
    {
        return $this->frequency && $frequency !== null;
    }

}