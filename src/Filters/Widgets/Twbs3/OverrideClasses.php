<?php

namespace Kalnoy\Shopping\Filters\Widgets\Twbs3;

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