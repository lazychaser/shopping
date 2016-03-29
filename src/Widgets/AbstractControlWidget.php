<?php

namespace Kalnoy\Shopping\Widgets;

abstract class AbstractControlWidget extends AbstractWidget
{
    /**
     * @var string
     */
    protected $id;

    /**
     * @param string $id
     * @param array $options
     */
    public function __construct($id, array $options = [ ])
    {
        parent::__construct($options);

        $this->id = $id;
    }

    /**
     * @param string $id
     * @param array $options
     *
     * @return static
     */
    public static function make($id, array $options = [])
    {
        return new static($id, $options);
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getContainerUniqueClass()
    {
        return 'AppFilter--'.$this->id;
    }
}