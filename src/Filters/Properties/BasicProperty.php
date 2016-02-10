<?php

namespace Kalnoy\Shopping\Filters\Properties;

use Illuminate\Database\Query\Builder;
use Kalnoy\Shopping\Contracts\Filters\Property;

/**
 * A property that works with specified attribute in the database table.
 */
class BasicProperty implements Property
{
    const NULL_VALUE = '__null';

    /**
     * The id of the attribute.
     *
     * @var string
     */
    protected $id;

    /**
     * @var array
     */
    public $join;

    /**
     * Init the attribute.
     *
     * @param string $id
     */
    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * {@inheritdoc}
     */
    public function where(Builder $query, $value, $operator = '=')
    {
        if ($value === self::NULL_VALUE) {
            if ($operator !== '=') throw new \InvalidArgumentException;

            return $query->whereNull($this->id);
        }

        return $query->where($this->id, $operator, $value);
    }

    /**
     * {@inheritdoc}
     */
    public function whereIn(Builder $query, array $values)
    {
        if (count($values) == 1) {
            return $this->where($query, reset($values));
        }

        // We'll see if values have null value that needs to be treated differently
        if (($pos = array_search(self::NULL_VALUE, $values, true)) !== false) {
            unset($values[$pos]);

            return $query->whereNested(function (Builder $inner) use ($values) {
                $inner->whereIn($this->id, $values)->orWhereNull($this->id);
            });
        }

        return $query->whereIn($this->id, $values);
    }

    /**
     * {@inheritdoc}
     */
    public function whereBetween(Builder $query, array $range)
    {
        return $query->whereBetween($this->id, $range);
    }

    /**
     * {@inheritdoc}
     */
    public function values(Builder $query)
    {
        $grammar = $query->getGrammar();

        $wrapped = $grammar->wrap($this->id);

        $query->selectRaw("case when {$wrapped} is null then '".
                          self::NULL_VALUE."' else {$wrapped} end".' as value');

        $query->selectRaw('count(1) as count');

        $query->groups = [ $this->id ];

        return $query->pluck('count', 'value');
    }

    /**
     * {@inheritdoc}
     */
    public function range(Builder $query)
    {
        foreach ([ 'min', 'max' ] as $func) {
            $query->selectRaw("{$func}({$this->id}) as $func");
        }

        return array_values((array)$query->first());
    }

}