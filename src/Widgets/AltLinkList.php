<?php

namespace Kalnoy\Shopping\Widgets;

use Kalnoy\Shopping\Contracts\Widgets\Option as OptionContract;

class AltLinkList extends LinkList
{

    /**
     * @var string
     */
    public $itemTemplate = '<a href="{href}" class="{class}">{title}{frequency}</a>';

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
        $title = $this->html ? $option->getTitle() : e($option->getTitle());
        
        $frequency = $this->shouldRenderFrequency($option->getFrequency()) 
            ? $this->renderFrequency($option->getFrequency())
            : '';

        return $this->renderTemplate($this->itemTemplate,
                                     compact('href', 'class', 'title', 'frequency'));
    }

    /**
     * @inheritDoc
     */
    protected function getBaseContainerClass()
    {
        return 'AltLinksFilter';
    }

}