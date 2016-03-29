<?php

namespace Kalnoy\Shopping\Widgets\Twbs3;

trait OverrideClasses
{
    /**
     * @return string
     */
    public function getActiveClass()
    {
        return $this->activeClass;
    }

    /**
     * @return string
     */
    public function getMutedClass()
    {
        return $this->mutedClass;
    }
}