<?php

namespace Lazychaser\Shopping\Widgets\Twbs3;

use Lazychaser\Shopping\Widgets\Select;

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