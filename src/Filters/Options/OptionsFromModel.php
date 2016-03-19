<?php

namespace Kalnoy\Shopping\Filters\Options;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Kalnoy\Shopping\Contracts\Filters\OptionsProvider;
use Kalnoy\Shopping\Filters\Properties\BasicProperty;

class OptionsFromModel implements OptionsProvider
{
    /**
     * @var array
     */
    protected $columns;

    /**
     * @var string|Model|Builder
     */
    protected $modelClass;

    /**
     * @var string|Closure
     */
    protected $title;

    /**
     * OptionsFromModel constructor.
     *
     * @param $modelClass
     * @param $title
     * @param array $columns
     */
    public function __construct($modelClass, $title, $columns = [ '*' ])
    {
        $this->columns = $columns;
        $this->modelClass = $modelClass;
        $this->title = $title;
    }

    /**
     * Get options for given keys.
     *
     * `$key => $title` map.
     *
     * @param array $keys
     *
     * @return array
     */
    public function options(array $keys)
    {
        $models = $this->newQuery()
            ->findMany($keys, $this->columns)
            ->getDictionary();

        return array_map([ $this, 'getModelTitle' ], $models);
    }

    /**
     * @param Model $model
     *
     * @return mixed
     */
    public function getModelTitle(Model $model)
    {
        if (is_string($this->title)) {
            return $model->getAttribute($this->title);
        }

        return call_user_func($this->title, $model);
    }

    /**
     * @return Builder
     */
    public function newQuery()
    {
        if (is_string($this->modelClass)) {
            return (new $this->modelClass)->newQuery();
        }

        if ($this->modelClass instanceof Model) {
            return $this->modelClass->newQuery();
        }

        return $this->modelClass;
    }
}