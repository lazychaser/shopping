<?php

namespace Lazychaser\Shopping\Widgets;

use Illuminate\Http\Request;
use Lazychaser\Shopping\Widgets\Options\Option;
use Lazychaser\Shopping\Contracts\Widgets\OptionsBuilder;
use Lazychaser\Shopping\Contracts\Widgets\Option as OptionContract;

abstract class AbstractOptionsWidget extends AbstractControlWidget
{
    /**
     * The list of options.
     *
     * @var array|OptionContract[]|OptionsBuilder
     */
    public $items = [ ];

    /**
     * @var bool
     */
    public $renderFrequency = true;

    /**
     * @var bool
     */
    public $multiple = true;

    /**
     * @var Request
     */
    protected $request;

    /**
     * @param array|OptionsBuilder $value
     *
     * @return $this
     */
    public function items($value)
    {
        $this->items = $value;
        
        return $this;
    }
    
    /**
     * Specify whether multiple options selection is allowed.
     *
     * @param bool $value
     *
     * @return $this
     */
    public function multiple($value = true)
    {
        $this->multiple = $value;

        return $this;
    }

    /**
     * Specify whether the frequency should be displayed.
     *
     * @param bool $value
     *
     * @return $this
     */
    public function hideFrequency($value = true)
    {
        $this->renderFrequency = ! $value;

        return $this;
    }

    /**
     * @return string
     */
    public function renderItems()
    {
        $html = PHP_EOL;

        foreach ($this->getArrayableItems() as $item) {
            if (is_array($item)) {
                $item = Option::fromArray($item);
            }

            $html .= $this->renderItem($item).PHP_EOL;
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
     * @param OptionContract $option
     *
     * @return bool
     */
    public function isActive(OptionContract $option)
    {
        if ($option->isActive() !== null) {
            return $option->isActive();
        }

        if (null === $value = $option->getValue()) {
            return false;
        }

        if ( ! $input = $this->getRequest()) {
            return false;
        }

        $input = $input->get($this->id);

        return is_array($input) ? in_array($value, $input) : $value == $input;
    }

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
    public function getContainerClass()
    {
        return $this->getBaseContainerClass().' '.
               $this->getContainerUniqueClass();
    }

    /**
     * @return string
     */
    abstract public function getBaseContainerClass();

    /**
     * @param $frequency
     *
     * @return bool
     */
    protected function shouldRenderFrequency($frequency)
    {
        return $this->renderFrequency && $frequency !== null;
    }

    /**
     * @param Request $request
     *
     * @return $this
     */
    public function setRequest(Request $request)
    {
        $this->request = $request;

        return $this;
    }

    /**
     * @return Request
     */
    public function getRequest()
    {
        return $this->request ?: app(Request::class);
    }
}