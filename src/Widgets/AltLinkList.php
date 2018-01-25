<?php

namespace Lazychaser\Shopping\Widgets;

use Lazychaser\Shopping\Contracts\Widgets\Option as OptionContract;

class AltLinkList extends LinkList
{

    /**
     * @var string
     */
    public $itemTemplate = '<a href="{href}" class="{class}">{option}{frequency}</a>';

    /**
     * @var string
     */
    public $template = '<div class="{class}">{items}</div>';

    /**
     * @param OptionContract $option
     *
     * @return string
     */
    protected function renderItem(OptionContract $option)
    {
        $href = $this->getHref($option);
        $class = $this->getItemClass($option);

        $frequency = $this->shouldRenderFrequency($option->getFrequency()) 
            ? $this->renderFrequency($option->getFrequency())
            : '';
        
        $option = $this->renderOption($option);

        return $this->renderTemplate($this->itemTemplate, compact('href', 
                                                                  'class',
                                                                  'option', 
                                                                  'frequency'));
    }

    /**
     * @inheritDoc
     */
    protected function renderOption(OptionContract $option)
    {
        return $this->html ? $option->getTitle() : e($option->getTitle());
    }

    /**
     * @inheritDoc
     */
    public function getBaseContainerClass()
    {
        return 'AltLinksFilter';
    }

}