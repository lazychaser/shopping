<?php

namespace Kalnoy\Shopping\Filters\Filters;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Arr;

/**
 * A kind of filter that filters by options.
 */
class OptionalFilter extends AbstractFilter
{
    /**
     * @var array
     */
    protected $options = [];

    /**
     * @var null|array
     */
    protected $valuableOptions;

    /**
     * @param $option
     *
     * @return bool
     */
    public function hasOption($option)
    {
        return array_key_exists($option, $this->options);
    }

    /**
     * {@inheritdoc}
     */
    protected function extractInput(array $data)
    {
        if ($value = array_get($data, $this->id)) {
            return array_intersect((array)$value, array_keys($this->options));
        }

        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function collectData(Builder $query)
    {
        $this->options = $this->property->values($query);
    }

    /**
     * {@inheritdoc}
     */
    public function collectValuableData(Builder $query)
    {
        $this->valuableOptions = $this->property->values($query);
    }

    /**
     * {@inheritdoc}
     */
    public function applyToBuilder(Builder $query)
    {
        if ($this->shouldConstraint()) {
            $this->property->whereIn($query, $this->input);
        }
    }

    /**
     * Get whether this filter should constraint.
     *
     * @return bool
     */
    public function shouldConstraint()
    {
        return $this->hasOptions(2) &&
               $this->hasInput() &&
             ! $this->inputHasAllOptions();
    }

    /**
     * Get whether user selected at least one sensible option.
     *
     * @return bool
     */
    public function inputHasValuableOptions()
    {
        if ( ! $this->hasInput() || ! $this->hasValuableOptions()) {
            return false;
        }

        foreach ($this->input as $option) {
            if ($this->optionIsValuable($option)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Get whether the value is active.
     *
     * @param mixed $option
     *
     * @return bool
     */
    public function inputHasOption($option)
    {
        return in_array($option, $this->input);
    }

    /**
     * Get whether user has selected every option.
     *
     * @return bool
     */
    public function inputHasAllOptions()
    {
        if ( ! $this->hasInput()) return false;

        $reference = $this->getFrequencySource();

        return count(array_diff(array_keys($reference), (array)$this->input)) == 0;
    }

    /**
     * Get whether filter has at least specified amount of options.
     *
     * @param int $atLeast
     *
     * @return bool
     */
    public function hasOptions($atLeast = 1)
    {
        return count($this->options) >= $atLeast;
    }

    /**
     * Get whether there are some significant options available.
     *
     * @return bool
     */
    public function hasValuableOptions()
    {
        return is_null($this->valuableOptions) ||
               ! empty($this->valuableOptions);
    }

    /**
     * Get whether the option changes the result set if selected.
     *
     * @param mixed $option
     *
     * @return bool
     */
    public function optionIsValuable($option)
    {
        return is_null($this->valuableOptions) ||
               array_key_exists($option, $this->valuableOptions);
    }

    /**
     * Get the number of items that have specified option.
     *
     * @param mixed $option
     *
     * @return int
     */
    public function optionFrequency($option)
    {
        if ( ! $this->hasOption($option)) return null;

        $source = $this->getFrequencySource();

        return Arr::get($source, $option, 0);
    }

    /**
     * Get frequency of all options in total.
     *
     * @return int
     */
    public function totalFrequency()
    {
        $source = $this->getFrequencySource();

        return array_sum($source);
    }

    /**
     * @return bool
     */
    public function hasInput()
    {
        return ! empty($this->input);
    }

    /**
     * Get all possible options.
     *
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * Get significant options.
     *
     * @return array
     */
    public function getValuableOptions()
    {
        return $this->valuableOptions;
    }

    /**
     * @return bool
     */
    public function hasData()
    {
        return $this->hasOptions(2);
    }

    /**
     * @return array|null
     */
    protected function getFrequencySource()
    {
        return is_null($this->valuableOptions)
            ? $this->options
            : $this->valuableOptions;
    }

}