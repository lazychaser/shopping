<?php

namespace Lazychaser\Shopping\Filters\Filters;

use Lazychaser\Shopping\Contracts\Filters\Filter;
use Lazychaser\Shopping\Contracts\Filters\Property;
use Illuminate\Database\Query\Builder;

/**
 * A base filter.
 */
abstract class AbstractFilter implements Filter
{
    /**
     * The id of the filter.
     *
     * @var string
     */
    protected $id;

    /**
     * The parameter.
     *
     * @var Property
     */
    protected $property;

    /**
     * The input.
     *
     * @var mixed
     */
    protected $input;

    /**
     * Init the filter.
     *
     * @param string $id
     * @param Property $property
     */
    public function __construct($id, Property $property)
    {
        $this->id = $id;
        $this->property = $property;
    }

    /**
     * Extract filter's data from the common input.
     *
     * @param array $data
     *
     * @return mixed
     */
    abstract protected function extractInput(array $data);

    /**
     * {@inheritdoc}
     */
    public function collectInput(array $data)
    {
        $this->input = $this->extractInput($data);

        return $this->hasInput();
    }

    /**
     * Get the filter's input.
     *
     * @return mixed
     */
    public function getInput()
    {
        return $this->input;
    }

    /**
     * Get whether the filter has input.
     *
     * @return bool
     */
    public function hasInput()
    {
        return $this->input !== null;
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the underlying property.
     *
     * @return Property
     */
    public function getProperty()
    {
        return $this->property;
    }

}