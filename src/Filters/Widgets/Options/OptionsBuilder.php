<?php

namespace Kalnoy\Shopping\Filters\Widgets\Options;

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