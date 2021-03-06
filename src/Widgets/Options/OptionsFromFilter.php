<?php

namespace Lazychaser\Shopping\Widgets\Options;

use Lazychaser\Shopping\Contracts\Widgets\OptionsBuilder;
use Lazychaser\Shopping\Filters\Filters\OptionalFilter;
use Lazychaser\Shopping\Contracts\Widgets\OptionsTitlesProvider;
use Lazychaser\Shopping\Filters\Properties\BasicProperty;

class OptionsFromFilter implements OptionsBuilder
{
    /**
     * @var string
     */
    public static $defaultNullValueLabel = 'Unknown';
    
    /**
     * @var OptionalFilter
     */
    protected $filter;

    /**
     * @var OptionsTitlesProvider
     */
    public $titlesProvider;

    /**
     * @var string
     */
    public $prompt;

    /**
     * @var string
     */
    public $nullValueLabel;

    /**
     * @param OptionalFilter $filter
     * @param OptionsTitlesProvider $titlesProvider
     * @param string $prompt
     * @param string $nullLabel
     */
    public function __construct(OptionalFilter $filter, $titlesProvider = null,
                                $prompt = null, $nullLabel = null
    ) {
        $this->filter = $filter;
        $this->titlesProvider = $titlesProvider;
        $this->prompt = $prompt;
        $this->nullValueLabel = $nullLabel;
    }

    /**
     * @param OptionalFilter $filter
     *
     * @return static
     */
    public static function make(OptionalFilter $filter)
    {
        return new static($filter);
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
            $data[] = $this->makeOption($this->getNullValueLabel(),
                                        BasicProperty::NULL_VALUE);
        }

        if ($this->titlesProvider) {
            $options = $this->titlesProvider->titlesForOptions($options);
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

    /**
     * @return string
     */
    public function getNullValueLabel()
    {
        return $this->nullValueLabel ?: static::$defaultNullValueLabel;
    }

    /**
     * Specify options titles provider.
     * 
     * @param OptionsTitlesProvider $provider
     *
     * @return $this
     */
    public function titlesFrom(OptionsTitlesProvider $provider)
    {
        $this->titlesProvider = $provider;
        
        return $this;
    }

    /**
     * Add prompt option (used mainly for select box).
     * 
     * @param string $title
     *
     * @return $this
     */
    public function addPrompt($title)
    {
        $this->prompt = $title;
        
        return $this;
    }

    /**
     * Specify a label for null value.
     * 
     * @param string $value
     *
     * @return $this
     */
    public function nullValueLabel($value)
    {
        $this->nullValueLabel = $value;
        
        return $this;
    }
}