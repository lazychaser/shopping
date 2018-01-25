<?php

namespace Lazychaser\Shopping\Widgets;

use Illuminate\Contracts\Support\Renderable;
use Lazychaser\Shopping\Support\Helpers;

abstract class AbstractWidget implements Renderable
{
    /**
     * @param string $id
     * @param array $options
     */
    public function __construct(array $options = [ ])
    {
        Helpers::configure($this, $options);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->render();
    }

    /**
     * @param string $template
     * @param array $data
     *
     * @return string
     */
    protected function renderTemplate($template, array $data)
    {
        return preg_replace_callback('/\{([a-z_\-]+)\}/',
            function ($matches) use ($data) {
                return array_get($data, $matches[1], '');
            }, $template);
    }

}