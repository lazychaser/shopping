<?php

namespace Kalnoy\Shopping\Filters;

use Closure;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection as BaseCollection;
use Kalnoy\Shopping\Contracts\Filters\Filter;
use RuntimeException;

/**
 * The filter collection.
 */
class Collection extends BaseCollection
{
    /**
     * @var bool
     */
    public $collectSignificantData = true;

    /**
     * Add a new filter to the collection.
     *
     * @param Filter $filter
     *
     * @return $this
     *
     * @throws RuntimeException
     */
    public function add(Filter $filter)
    {
        if ($this->has($id = $filter->getId())) {
            throw new RuntimeException("The filter with an id of [{$id}] is already defined.");
        }

        $this->put($id, $filter);

        return $this;
    }

    /**
     * Apply filters.
     *
     * @param Builder $query
     * @param array $input
     * @param Closure $filter
     *
     * @return Builder
     */
    public function applyFilters(Builder $query, array $input,
                                 Closure $filter = null)
    {
        $this->gatherData($query);

        if ($filter) $filter($query, $input);

        if ( ! $this->gatherInput($input)) {
            return $query;
        }

        if ($this->collectSignificantData) {
            $this->gatherSignificantData($query);
        }

        return $this->constraint($query);
    }

    /**
     * Gather data for every filter.
     *
     * @param Builder $query
     *
     * @return void
     */
    protected function gatherData(Builder $query)
    {
        /** @var Filter $filter */
        foreach ($this->items as $filter) {
            $filter->gatherData(clone $query);
        }
    }

    /**
     * Gather input for every filter.
     *
     * @param array $input
     *
     * @return bool
     */
    protected function gatherInput(array $input)
    {
        $hasInput = false;

        /** @var Filter $filter */
        foreach ($this->items as $filter) {
            $hasInput = $filter->gatherInput($input) || $hasInput;
        }

        return $hasInput;
    }

    /**
     * Gather sensible data for every filter.
     *
     * @param Builder $query
     *
     * @return void
     */
    protected function gatherSignificantData(Builder $query)
    {
        /** @var Filter $filter */
        foreach ($this->items as $filter) {
            $constrainedQuery = $this->constraint(clone $query, $filter);

            $filter->gatherSignificantData($constrainedQuery);
        }
    }

    /**
     * Constraint the query builder with filters.
     *
     * @param Builder $query
     * @param Filter $except
     *
     * @return Builder
     */
    protected function constraint(Builder $query, $except = null)
    {
        /** @var Filter $filter */
        foreach ($this->items as $filter) {
            if ($filter !== $except) {
                $filter->constraint($query);
            }
        }

        return $query;
    }

}