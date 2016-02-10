<?php

namespace Kalnoy\Shopping\Filters\Filters;

use Kalnoy\Shopping\Contracts\Filters\Filter;
use Kalnoy\Shopping\Contracts\Filters\Property;
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
    protected $parameter;

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
     * @param Property $parameter
     */
    public function __construct($id, Property $parameter)
    {
        $this->id = $id;
        $this->parameter = $parameter;
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
    public function gatherInput(array $data)
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
     * Get the underlying parameter.
     *
     * @return Property
     */
    public function getParameter()
    {
        return $this->parameter;
    }

}