<?php

namespace Kalnoy\Shopping\Widgets\Options\TitleProviders;

class ArrayTitles extends AbstractProvider
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
    public function titlesForOptions(array $keys)
    {
        $keys = array_combine($keys, $keys);

        return array_intersect_key($this->options, $keys);
    }

}