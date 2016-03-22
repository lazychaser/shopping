<?php

namespace Kalnoy\Shopping\Filters;

use Closure;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection as BaseCollection;
use Kalnoy\Shopping\Contracts\Filters\Filter;
use InvalidArgumentException;
use Traversable;

/**
 * The filter collection.
 */
class Collection implements \ArrayAccess, \IteratorAggregate, \Countable
{
    /**
     * @var Filter[]
     */
    protected $items = [];

    /**
     * @var bool
     */
    public $collectValuableData = true;

    /**
     * Collection constructor.
     *
     * @param array $items
     */
    public function __construct(array $items = [])
    {
        foreach ($items as $item) {
            $this->add($item);
        }
    }

    /**
     * @param string|Filter $filter
     *
     * @return bool
     */
    public function has($filter)
    {
        if ($filter instanceof Filter) {
            $filter = $filter->getId();
        }

        return $this->offsetExists($filter);
    }

    /**
     * @param string $filter
     * @param mixed $default
     *
     * @return Filter
     */
    public function get($filter, $default = null)
    {
        if ($this->offsetExists($filter)) {
            return $this->items[$filter];
        }

        return value($default);
    }

    /**
     * Add a new filter to the collection.
     *
     * @param Filter $filter
     *
     * @return $this
     *
     * @throws InvalidArgumentException
     */
    public function add(Filter $filter)
    {
        if ($this->has($filter)) {
            throw new InvalidArgumentException("Cannot add filter [{$filter->getId()}] since it is already defined.");
        }

        $this->items[$filter->getId()] = $filter;

        return $this;
    }

    /**
     * Apply filters to the query builder.
     *
     * @param Builder $query
     * @param array $input
     * @param Closure $customFilter
     *
     * @return Builder
     */
    public function applyToBuilder(Builder $query, array $input,
                                   Closure $customFilter = null)
    {
        $this->collectData($query);

        if ($customFilter) {
            $customFilter($query, $input);
        }

        // If none of the filters has some valuable input, just skip
        if ( ! $this->collectInput($input)) {
            return $query;
        }

        if ($this->collectValuableData) {
            $this->collectValuableData($query);
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
    protected function collectData(Builder $query)
    {
        /** @var Filter $filter */
        foreach ($this->items as $filter) {
            $filter->collectData(clone $query);
        }
    }

    /**
     * Gather input for every filter.
     *
     * @param array $input
     *
     * @return bool
     */
    protected function collectInput(array $input)
    {
        $hasInput = false;

        /** @var Filter $filter */
        foreach ($this->items as $filter) {
            $hasInput = $filter->collectInput($input) || $hasInput;
        }

        return $hasInput;
    }

    /**
     * Gather valuable data for every filter.
     *
     * @param Builder $query
     *
     * @return void
     */
    protected function collectValuableData(Builder $query)
    {
        /** @var Filter $filter */
        foreach ($this->items as $filter) {
            $constrainedQuery = $this->constraint(clone $query, $filter);

            $filter->collectValuableData($constrainedQuery);
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
                $filter->applyToBuilder($query);
            }
        }

        return $query;
    }

    /**
     * Retrieve an external iterator
     *
     * @link  http://php.net/manual/en/iteratoraggregate.getiterator.php
     * @return Traversable An instance of an object implementing <b>Iterator</b> or
     *        <b>Traversable</b>
     * @since 5.0.0
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->items);
    }

    /**
     * Whether a offset exists
     *
     * @link  http://php.net/manual/en/arrayaccess.offsetexists.php
     *
     * @param mixed $offset <p>
     *                      An offset to check for.
     *                      </p>
     *
     * @return boolean true on success or false on failure.
     * </p>
     * <p>
     * The return value will be casted to boolean if non-boolean was returned.
     * @since 5.0.0
     */
    public function offsetExists($offset)
    {
        return array_key_exists($offset, $this->items);
    }

    /**
     * Offset to retrieve
     *
     * @link  http://php.net/manual/en/arrayaccess.offsetget.php
     *
     * @param mixed $offset <p>
     *                      The offset to retrieve.
     *                      </p>
     *
     * @return mixed Can return all value types.
     * @since 5.0.0
     */
    public function offsetGet($offset)
    {
        return $this->items[$offset];
    }

    /**
     * Offset to set
     *
     * @link  http://php.net/manual/en/arrayaccess.offsetset.php
     *
     * @param mixed $offset <p>
     *                      The offset to assign the value to.
     *                      </p>
     * @param mixed $value  <p>
     *                      The value to set.
     *                      </p>
     *
     * @return void
     * @since 5.0.0
     */
    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->add($value);
        } else {
            $this->items[$offset] = $value;
        }
    }

    /**
     * Offset to unset
     *
     * @link  http://php.net/manual/en/arrayaccess.offsetunset.php
     *
     * @param mixed $offset <p>
     *                      The offset to unset.
     *                      </p>
     *
     * @return void
     * @since 5.0.0
     */
    public function offsetUnset($offset)
    {
        unset($this->items[$offset]);
    }

    /**
     * Count elements of an object
     *
     * @link  http://php.net/manual/en/countable.count.php
     * @return int The custom count as an integer.
     *        </p>
     *        <p>
     *        The return value is cast to an integer.
     * @since 5.1.0
     */
    public function count()
    {
        return count($this->items);
    }

}