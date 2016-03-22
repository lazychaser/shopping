<?php

namespace Kalnoy\Shopping\Widgets\Twbs3;

use Kalnoy\Shopping\Widgets\AltLinkList;
use Kalnoy\Shopping\Contracts\Widgets\Option as OptionContract;

class ButtonGroup extends AltLinkList
{
    use UsesButtons, OverrideClasses;

    /**
     * @inheritDoc
     */
    protected function getItemClasses(OptionContract $option)
    {
        return array_merge(parent::getItemClasses($option),
                           $this->getButtonClasses());
    }

    /**
     * @return string
     */
    protected function getContainerClass()
    {
        return parent::getContainerClass().' '.$this->getButtonGroupClass();
    }
}