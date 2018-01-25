<?php

namespace Lazychaser\Shopping\Widgets\Twbs3;

use Lazychaser\Shopping\Widgets\AltLinkList;
use Lazychaser\Shopping\Contracts\Widgets\Option as OptionContract;

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
    public function getContainerClass()
    {
        return parent::getContainerClass().' '.$this->getButtonGroupClass();
    }
}