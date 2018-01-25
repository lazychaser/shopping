<?php

namespace Lazychaser\Shopping\Widgets\Wrappers;

use Illuminate\Contracts\Support\Renderable;
use Lazychaser\Shopping\Widgets\AbstractWidget;

abstract class AbstractWrapper extends AbstractWidget
{
    /**
     * @var Renderable|string
     */
    public $inner;

    /**
     * @param Renderable $inner
     *
     * @return static
     */
    public static function wrap(Renderable $inner)
    {
        $instance = new static;
        
        $instance->inner = $inner;
        
        return $instance;
    }

    /**
     * @return string
     */
    protected function renderInner()
    {
        if ($this->inner instanceof Renderable) {
            return $this->inner->render();
        }

        return $this->inner;
    }
}