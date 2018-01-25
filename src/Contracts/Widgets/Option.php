<?php

namespace Lazychaser\Shopping\Contracts\Widgets;

interface Option
{
    /**
     * @return string
     */
    public function getTitle();

    /**
     * @return string
     */
    public function getValue();

    /**
     * @return bool
     */
    public function isActive();

    /**
     * @return int
     */
    public function getFrequency();
}