<?php

namespace Kalnoy\Shopping\Filters\Properties;

use Illuminate\Database\Query\Builder;
use Kalnoy\Shopping\Contracts\Filters\Property;

/**
 * A property that works with specified attribute in the database table.
 */
class BasicProperty extends AbstractProperty
{
    /**
     * The id of the property.
     *
     * @var string
     */
    protected $id;

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
     * @param Builder $query
     *
     * @return string
     */
    protected function initQuery(Builder $query)
    {
        return $this->id;
    }

}