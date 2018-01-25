<?php

namespace Lazychaser\Shopping\Contracts\Widgets;

/**
 * Provides options for optional widget.
 */
interface OptionsBuilder
{
    /**
     * @return Option[]|array
     */
    public function options();
}