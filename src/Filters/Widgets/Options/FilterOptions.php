<?php

namespace Kalnoy\Shopping\Filters\Widgets\Options;

use Kalnoy\Shopping\Filters\Filters\OptionalFilter;
use Kalnoy\Shopping\Contracts\Filters\OptionsProvider;

class FilterOptions implements OptionsBuilder
{
    /**
     * @var OptionalFilter
     */
    protected $filter;

    /**
     * @var OptionsProvider
     */
    protected $provider;

    /**
     * @var string
     */
    protected $prompt;

    /**
     * @param OptionalFilter $filter
     * @param OptionsProvider $provider
     * @param string $prompt
     */
    public function __construct(OptionalFilter $filter, $provider = null,
                                $prompt = null
    ) {
        $this->filter = $filter;
        $this->provider = $provider;
        $this->prompt = $prompt;
    }

    /**
     * @return Option[]|array
     */
    public function options()
    {
        $data = [ ];

        if ($this->prompt) $data[] = [ 'title' => $this->prompt ];

        $options = array_keys($this->filter->getOptions());

        if ($this->provider) {
            $options = $this->provider->options($options);
        } else {
            sort($options);

            $options = array_combine($options, $options);
        }

        foreach ($options as $value => $title) {
            $data[] = $this->makeOption($title, $value);
        }

        return $data;
    }

    /**
     * @param string $title
     * @param mixed $value
     *
     * @return Option
     */
    protected function makeOption($title, $value)
    {
        return new Option($value, $title,
                          $this->filter->getFrequency($value),
                          $this->filter->isActive($value));
    }

}