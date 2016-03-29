<?php

namespace Kalnoy\Shopping\Widgets\Twbs3\Wrappers;

use Kalnoy\Shopping\Widgets\AbstractControlWidget;
use Kalnoy\Shopping\Widgets\Wrappers\AbstractWrapper;

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
     * @param $value
     *
     * @return $this
     */
    public function title($value)
    {
        $this->title = $value;
        
        return $this;
    }

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
        return $this->title ?: $this->getId();
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

        throw new \RuntimeException("The id for tab pane is not specified.");
    }
}