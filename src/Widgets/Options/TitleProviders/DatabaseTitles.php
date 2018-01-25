<?php

namespace Lazychaser\Shopping\Widgets\Options\TitleProviders;

use Illuminate\Database\Query\Builder;

class DatabaseTitles extends AbstractProvider
{
    /**
     * @var \Illuminate\Database\Query\Builder
     */
    protected $query;

    /**
     * The column that identifies the item.
     *
     * @var string
     */
    protected $key;

    /**
     * The value that identifies the item.
     *
     * @var string
     */
    protected $value;

    /**
     * @param Builder $query
     * @param $key
     * @param $value
     */
    public function __construct(Builder $query, $key, $value)
    {
        $this->query = $query;
        $this->key = $key;
        $this->value = $value;
    }

    /**
     * @param array $keys
     *
     * @return array
     */
    public function titlesForOptions(array $keys)
    {
        $query = clone $this->query;

        return $query->whereIn($this->key, $keys)
                        ->pluck($this->value, $this->key);
    }

}