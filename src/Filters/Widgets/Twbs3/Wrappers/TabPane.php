<?php

namespace Kalnoy\Shopping\Filters\Widgets\Twbs3\Wrappers;

use Kalnoy\Shopping\Filters\Widgets\AbstractControlWidget;

class TabPane extends AbstractWrapper
{
    /**
     * @var string
     */
    public $id;

    /**
     * @var string
     */
    public $title;

    /**
     * Get the evaluated contents of the object.
     *
     * @return string
     */
    public function render()
    {
        return $this->renderInner();
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getId()
    {
        if ($this->id) return $this->id;

        if ($this->inner instanceof AbstractControlWidget) {
            return $this->inner->getId();
        }

        throw new \RuntimeException("Id for tab pane is not specified.");
    }
}