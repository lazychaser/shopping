<?php

namespace Kalnoy\Shopping\Contracts\Filters;

use Illuminate\Database\Query\Builder;

/**
 * A base interface for every filter.
 */
interface Filter
{
    /**
     * Gather available data for the filter.
     *
     * @param \Illuminate\Database\Eloquent\Builder|Builder $query
     *
     * @return mixed
     */
    public function gatherData(Builder $query);

    /**
     * Gather data that is available with other applied filters.
     *
     * @param \Illuminate\Database\Eloquent\Builder|Builder $query
     *
     * @return mixed
     */
    public function gatherSignificantData(Builder $query);

    /**
     * Gather input for the filter.
     *
     * @param array $data
     *
     * @return bool
     */
    public function gatherInput(array $data);

    /**
     * Add constraints based on the collected input.
     *
     * @param \Illuminate\Database\Query\Builder $query
     */
    public function constraint(Builder $query);

    /**
     * Get the id of the filter.
     *
     * @return string
     */
    public function getId();

    /**
     * @return bool
     */
    public function hasData();

}