<?php

namespace Kalnoy\Shopping\Filters\Properties;

use Illuminate\Database\Query\Builder;
use Kalnoy\Shopping\Contracts\Filters\Property;

abstract class AbstractProperty implements Property
{
    /**
     * The value that is treated as null value of the property.
     */
    const NULL_VALUE = '_';

    /**
     * {@inheritdoc}
     */
    public function where(Builder $query, $value, $operator = '=')
    {
        if ($value === self::NULL_VALUE) {
            $value = null;
        }

        return $query->where($this->initQuery($query), $operator, $value);
    }

    /**
     * {@inheritdoc}
     */
    public function whereIn(Builder $query, array $values)
    {
        if (count($values) == 1) {
            return $this->where($query, reset($values));
        }

        $column = $this->initQuery($query);

        // We'll see if values have null value that needs to be treated differently
        if (($pos = array_search(self::NULL_VALUE, $values, true)) !== false) {
            unset($values[$pos]);

            return $query->whereNested(function (Builder $inner) use (
                $values, $column
            ) {
                $inner->whereIn($column, $values)->orWhereNull($column);
            });
        }

        return $query->whereIn($column, $values);
    }

    /**
     * {@inheritdoc}
     */
    public function whereBetween(Builder $query, array $range)
    {
        $column = $this->initQuery($query);

        return $query->whereBetween($column, $range)->orWhereNull($column);
    }

    /**
     * {@inheritdoc}
     */
    public function values(Builder $query)
    {
        $column = $this->initQuery($query);

        $wrapped = $query->getGrammar()->wrap($column);

        $query->selectRaw("case when {$wrapped} is null then '".
                          self::NULL_VALUE."' else {$wrapped} end".' as value');

        $query->selectRaw('count(1) as count');

        $query->groups = [ $column ];

        return $query->pluck('count', 'value');
    }

    /**
     * {@inheritdoc}
     */
    public function range(Builder $query)
    {
        $column = $this->initQuery($query);

        $column = $query->getGrammar()->wrap($column);

        foreach ([ 'min', 'max' ] as $func) {
            $query->selectRaw("{$func}({$column}) as $func");
        }

        return array_values((array)$query->first());
    }

    /**
     * Init the query builder and return the name of the target column.
     *
     * @param Builder $query
     *
     * @return string
     */
    abstract protected function initQuery(Builder $query);
}