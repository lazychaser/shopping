<?php

namespace Kalnoy\Shopping\Filters\Widgets\Twbs3;

use Kalnoy\Shopping\Filters\Widgets\LinkList;

class ButtonDropdown extends LinkList
{
    use UsesButtons, OverrideClasses;

    /**
     * @var string
     */
    public $manyItemsTitle = 'Множественный выбор';

    /**
     * @var string
     */
    public $template = '<div class="{class}">{button}<ul class="dropdown-menu">{items}</ul></div>';

    /**
     * @return string
     */
    public function render()
    {
        $items = $this->renderItems();
        $class = $this->getContainerClass().' '.$this->getContainerUniqueClass();
        $button = $this->renderButton();

        return $this->renderTemplate($this->template,
                                     compact('items', 'class', 'button'));
    }

    /**
     * Present the dropdown toggler.
     *
     * @return string
     */
    private function renderButton()
    {
        $class = $this->getButtonClass().' dropdown-toggle';
        $title = $this->getActiveOptionTitle();

        if ( ! $this->html) $title = e($title);

        return '<button type="button" class="'.$class.'" data-toggle="dropdown">'.
                $title.' <span class="caret"></span></button>';
    }

    /**
     * Get the title of selected option.
     *
     * @return string
     */
    private function getActiveOptionTitle()
    {
        foreach ($this->items as $item) {
            if ($this->isActive($item)) {
                return $item->title;
            }
        }

        return '<ошибка>';
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
        return 'DropdownButtonFilter';
    }

}