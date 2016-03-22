<?php

namespace Kalnoy\Shopping\Contracts\Widgets;

/**
 * Provides options for a set of given keys.
 *
 * I.e. returns titles for a list of model keys.
 */
interface OptionsTitlesProvider
{
    /**
     * Get titles for given set of keys.
     *
     * @param array $keys
     *
     * @return array `$option => $title` map
     */
    public function titlesForOptions(array $keys);

}