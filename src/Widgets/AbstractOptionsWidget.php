<?php

namespace Kalnoy\Shopping\Widgets;

use Kalnoy\Shopping\Widgets\Options\Option;
use Kalnoy\Shopping\Contracts\Widgets\OptionsBuilder;
use Kalnoy\Shopping\Contracts\Widgets\Option as OptionContract;

abstract class AbstractOptionsWidget extends AbstractControlWidget
{
    /**
     * The list of options.
     *
     * @var array|OptionContract[]
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
     * @param OptionContract $option
     *
     * @return string
     */
    abstract protected function renderItem(OptionContract $option);

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