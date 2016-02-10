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
     * The list of options.
     *
     * @var array
     */
    protected $options = [];

    /**
     * Available options.
     *
     * @var null|array
     */
    protected $available;

    /**
     * Get whether the value is active.
     *
     * @param mixed $value
     *
     * @return bool
     */
    public function isActive($value)
    {
        return in_array($value, $this->input);
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
    public function gatherData(Builder $query)
    {
        $this->options = $this->parameter->values($query);
    }

    /**
     * {@inheritdoc}
     */
    public function gatherSensibleData(Builder $query)
    {
        $this->available = $this->parameter->values($query);
    }

    /**
     * {@inheritdoc}
     */
    public function constraint(Builder $query)
    {
        if ($this->shouldConstraint()) {
            $this->parameter->whereIn($query, $this->input);
        }
    }

    /**
     * Get whether this filter should constraint.
     *
     * @return bool
     */
    public function shouldConstraint()
    {
        return $this->hasOptions(2) && $this->hasInput() &&
             ! $this->inputHasAllOptions();
    }

    /**
     * Get whether user selected at least one sensible option.
     *
     * @return bool
     */
    public function inputHasSensibleOptions()
    {
        if ( ! $this->hasInput() || ! $this->hasSensibleOptions()) {
            return false;
        }

        foreach ($this->input as $option) {
            if ($this->isSensible($option)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Get whether user has selected every option.
     *
     * @return bool
     */
    public function inputHasAllOptions()
    {
        if ( ! $this->hasInput()) return false;

        $reference = is_null($this->available)
            ? $this->options
            : $this->available;

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
     * Get whether there are some sensible options available.
     *
     * @return bool
     */
    public function hasSensibleOptions()
    {
        return is_null($this->available) || ! empty($this->available);
    }

    /**
     * Get whether the option is sensible.
     *
     * @param mixed $option
     *
     * @return bool
     */
    public function isSensible($option)
    {
        return is_null($this->available) ||
               array_key_exists($option, $this->available);
    }

    /**
     * @return bool
     */
    public function hasInput()
    {
        return isset($this->input) and ! empty($this->input);
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
     * Get available options.
     *
     * @return array
     */
    public function getAvailableOptions()
    {
        return $this->available;
    }

    /**
     * Get the number of items that have specified option.
     *
     * @param mixed $option
     *
     * @return int
     */
    public function getFrequency($option)
    {
        $source = is_null($this->available) ? $this->options : $this->available;

        if (is_null($option)) {
            return array_sum($source);
        }

        if ( ! isset($this->options[$option])) return null;

        return Arr::get($source, $option, 0);
    }

    /**
     * @return bool
     */
    public function hasData()
    {
        return $this->hasOptions(2);
    }

}