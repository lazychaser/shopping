<?php

namespace Lazychaser\Shopping\Widgets\Twbs3;

use Lazychaser\Shopping\Widgets\CheckableList;
use Lazychaser\Shopping\Contracts\Widgets\Option as OptionContract;

class ButtonCheckableList extends CheckableList
{
    use UsesButtons, OverrideClasses;

    /**
     * @var string
     */
    public $template = '<div class="{class}" data-toggle="buttons">{items}</div>';

    /**
     * @var string
     */
    public $itemTemplate = '<label class="{class}">'.PHP_EOL.'{option}{frequency}'.PHP_EOL.'</label>';

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

    /**
     * @inheritDoc
     */
    public function getBaseContainerClass()
    {
        return 'CheckableButtonsFilter';
    }

    /**
     * @inheritDoc
     */
    protected function getCheckableClass()
    {
        return $this->getCheckableType();
    }

}