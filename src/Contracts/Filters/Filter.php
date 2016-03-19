<?php

namespace Kalnoy\Shopping\Contracts\Filters;

use Illuminate\Database\Query\Builder;

/**
 * A base interface for every filter.
 */
interface Filter
{
    /**
     * Collect available data for the filter.
     *
     * @param Builder $query
     *
     * @return mixed
     */
    public function collectData(Builder $query);

    /**
     * Collect data that is available with other applied filters.
     *
     * @param Builder $query
     *
     * @return mixed
     */
    public function collectValuableData(Builder $query);

    /**
     * Collect input for the filter.
     *
     * @param array $data
     *
     * @return bool
     */
    public function collectInput(array $data);

    /**
     * Add constraints based on the collected input.
     *
     * @param \Illuminate\Database\Query\Builder $query
     */
    public function applyToBuilder(Builder $query);

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