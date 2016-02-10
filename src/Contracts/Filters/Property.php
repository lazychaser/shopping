<?php

namespace Kalnoy\Shopping\Contracts\Filters;

use Illuminate\Database\Query\Builder;

/**
 * Filter property interface.
 */
interface Property
{
    /**
     * Add equality constraint.
     *
     * @param \Illuminate\Database\Query\Builder $query
     * @param mixed  $value
     *
     * @return \Illuminate\Database\Query\Builder
     */
    public function where(Builder $query, $value, $operator = '=');

    /**
     * Add parameter constraints to the query builder.
     *
     * @param \Illuminate\Database\Query\Builder $query
     * @param array $values
     *
     * @return \Illuminate\Database\Query\Builder
     */
    public function whereIn(Builder $query, array $values);

    /**
     * Add range constraint.
     *
     * @param \Illuminate\Database\Query\Builder $query
     * @param array $range
     *
     * @return \Illuminate\Database\Query\Builder
     */
    public function whereBetween(Builder $query, array $range);

    /**
     * Get a list of possible values.
     *
     * @param \Illuminate\Database\Query\Builder $query
     *
     * @return array
     */
    public function values(Builder $query);

    /**
     * Get a range of numeric values.
     *
     * @param \Illuminate\Database\Query\Builder $query
     *
     * @return array
     */
    public function range(Builder $query);

}