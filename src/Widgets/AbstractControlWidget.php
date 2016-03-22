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
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    final public function getContainerUniqueClass()
    {
        return 'AppFilter--'.$this->id;
    }
}