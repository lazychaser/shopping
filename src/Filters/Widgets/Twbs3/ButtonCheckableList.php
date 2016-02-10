<?php

namespace Kalnoy\Shopping\Filters\Widgets\Twbs3;

use Kalnoy\Shopping\Filters\Widgets\CheckableList;
use Kalnoy\Shopping\Filters\Widgets\Options\Option;

class ButtonCheckableList extends CheckableList
{
    use UsesButtons;

    /**
     * @var string
     */
    public $template = '<div class="{class}" data-toggle="buttons">{items}</div>';

    /**
     * @var string
     */
    public $itemTemplate = '<label class="{class}">{option}{frequency}</label>';

    /**
     * @inheritDoc
     */
    protected function getItemClasses(Option $option)
    {
        return array_merge(parent::getItemClasses($option), $this->getButtonClasses());
    }

    /**
     * @return string
     */
    protected function getContainerClass()
    {
        return parent::getContainerClass().' '.$this->getButtonGroupClass();
    }

    /**
     * @inheritDoc
     */
    protected function getBaseContainerClass()
    {
        return 'CheckableButtonsFilter';
    }

}