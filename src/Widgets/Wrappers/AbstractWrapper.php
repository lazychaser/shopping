<?php

namespace Kalnoy\Shopping\Widgets\Wrappers;

use Illuminate\Contracts\Support\Renderable;
use Kalnoy\Shopping\Widgets\AbstractWidget;

abstract class AbstractWrapper extends AbstractWidget
{
    /**
     * @var Renderable|string
     */
    public $inner;

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