<?php

namespace Kalnoy\Shopping\Widgets\Twbs3;

use Kalnoy\Shopping\Contracts\Widgets\Option as OptionContract;
use Kalnoy\Shopping\Widgets\LinkList;

class ButtonDropdown extends LinkList
{
    use UsesButtons, OverrideClasses;

    /**
     * @var bool
     */
    public $multiple = false;

    /**
     * @var string
     */
    public $title;

    /**
     * @var string
     */
    public $glue = ', ';

    /**
     * @return string
     */
    public function render()
    {
        $items = $this->renderItems();
        $class = $this->getContainerClass();
        $button = $this->renderButton();

        return '<div class="'.$class.'">'.PHP_EOL.
                    $button.PHP_EOL.
                    '<ul class="dropdown-menu">'.$items.'</ul>'.PHP_EOL.
               '</div>';
    }

    /**
     * @inheritDoc
     */
    protected function renderItem(OptionContract $option)
    {
        $class = $this->getItemClass($option);

        return '<li class="'.$class.'">'.PHP_EOL.
                    $this->renderOption($option).PHP_EOL.
               '</li>';
    }

    /**
     * @inheritDoc
     */
    protected function renderFrequency($frequency)
    {
        return $frequency
            ? '<span class="badge">'.$frequency.'</span>'
            : '';
    }

    /**
     * @inheritDoc
     */
    protected function renderOption(OptionContract $option)
    {
        $href = $this->getHref($option);
        $title = $this->html ? $option->getTitle() : e($option->getTitle());
        $badge = $this->shouldRenderFrequency($option->getFrequency())
            ? $this->renderFrequency($option->getFrequency())
            : '';

        return '<a href="'.$href.'">'.$title.$badge.'</a>';
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
        $active = [];

        foreach ($this->items as $item) {
            if ($this->isActive($item)) {
                $active[] = $this->html ? $item->getTitle() : e($item->getTitle());
            }
        }

        return empty($active) ? $this->getTitle() : implode($this->glue, $active);
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
        return 'DropdownButtonFilter';
    }

    /**
     * @return mixed
     */
    protected function getTitle()
    {
        return $this->title ?: $this->id;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function title($value)
    {
        $this->title = $value;
        
        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function glue($value)
    {
        $this->glue = $value;
        
        return $this;
    }
}