<?php

namespace Kalnoy\Shopping\Filters\Widgets\Twbs3;

use Kalnoy\Shopping\Filters\Widgets\AltLinkList;
use Kalnoy\Shopping\Filters\Widgets\Options\Option;

class ButtonGroup extends AltLinkList
{
    use UsesButtons, OverrideClasses;

    /**
     * @inheritDoc
     */
    protected function getItemClasses(Option $option)
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