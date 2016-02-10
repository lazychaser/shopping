<?php

namespace Kalnoy\Shopping\Filters\Options;

use Kalnoy\Shopping\Contracts\Filters\OptionsProvider;

class ArrayOptions implements OptionsProvider
{
    /**
     * @var array
     */
    protected $options;

    /**
     * @param array $options
     */
    public function __construct(array $options)
    {
        $this->options = $options;
    }

    /**
     * Get the value for each option with specified key.
     *
     * @param array $keys
     *
     * @return array
     */
    public function options(array $keys)
    {
        $keys = array_combine($keys, $keys);

        return array_intersect_key($this->options, $keys);
    }

}