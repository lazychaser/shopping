<?php

namespace Kalnoy\Shopping\Contracts\Filters;

/**
 * Provides options for a set of given keys.
 *
 * I.e. returns titles for a list of model keys.
 */
interface OptionsProvider
{
    /**
     * Get options for given keys.
     *
     * `$key => $title` map.
     *
     * @param array $keys
     *
     * @return array
     */
    public function options(array $keys);

}