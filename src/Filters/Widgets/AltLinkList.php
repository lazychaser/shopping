<?php

namespace Kalnoy\Shopping\Filters\Widgets;

use Kalnoy\Shopping\Filters\Widgets\Options\Option;

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
     * @param Option $option
     *
     * @return string
     */
    protected function renderItem(Option $option)
    {
        $href = $this->getHref($option);
        $class = $this->getItemClass($option);
        $title = $this->html ? $option->title : e($option->title);
        $frequency = $this->renderFrequency($option->frequency);

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