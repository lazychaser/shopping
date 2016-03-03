<?php

namespace Kalnoy\Shopping\Filters\Widgets\Options;

use Kalnoy\Shopping\Filters\Filters\OptionalFilter;
use Kalnoy\Shopping\Contracts\Filters\OptionsProvider;
use Kalnoy\Shopping\Filters\Properties\BasicProperty;

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
     * @var string
     */
    private $nullLabel;

    /**
     * @param OptionalFilter $filter
     * @param OptionsProvider $provider
     * @param string $prompt
     * @param string $nullLabel
     */
    public function __construct(OptionalFilter $filter, $provider = null,
                                $prompt = null, $nullLabel = 'Unknown'
    ) {
        $this->filter = $filter;
        $this->provider = $provider;
        $this->prompt = $prompt;
        $this->nullLabel = $nullLabel;
    }

    /**
     * @return Option[]|array
     */
    public function options()
    {
        $data = [ ];

        if ($this->prompt) {
            $data[] = new Option(null, $this->prompt);
        }

        $options = array_keys($this->filter->getOptions());

        if (in_array(BasicProperty::NULL_VALUE, $options)) {
            $data[] = $this->makeOption($this->nullLabel,
                                        BasicProperty::NULL_VALUE);
        }

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
                          $this->filter->optionFrequency($value),
                          $this->filter->inputHasOption($value));
    }

}