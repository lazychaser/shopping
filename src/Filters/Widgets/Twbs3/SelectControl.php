<?php

namespace Kalnoy\Shopping\Filters\Widgets\Twbs3;

use Kalnoy\Shopping\Filters\Widgets\Select;

class SelectControl extends Select
{
    /**
     * @var null|string
     */
    public $size = null;

    /**
     * @return string
     */
    protected function getContainerClass()
    {
        return parent::getContainerClass().' form-control'.($this->size ? ' input-'.$this->size : '');
    }

}