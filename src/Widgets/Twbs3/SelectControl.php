<?php

namespace Kalnoy\Shopping\Widgets\Twbs3;

use Kalnoy\Shopping\Widgets\Select;

class SelectControl extends Select
{
    /**
     * @var null|string
     */
    public $size = null;

    /**
     * @return string
     */
    public function getContainerClass()
    {
        return parent::getContainerClass().' form-control'.($this->size ? ' input-'.$this->size : '');
    }

}