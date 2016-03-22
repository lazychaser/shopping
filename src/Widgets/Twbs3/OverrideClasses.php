<?php

namespace Kalnoy\Shopping\Widgets\Twbs3;

trait OverrideClasses
{
    /**
     * @return string
     */
    protected function getActiveClass()
    {
        return $this->activeClass;
    }

    /**
     * @return string
     */
    protected function getMutedClass()
    {
        return $this->mutedClass;
    }
}