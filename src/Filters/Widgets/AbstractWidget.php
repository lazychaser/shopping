<?php

namespace Kalnoy\Shopping\Filters\Widgets;

use Illuminate\Contracts\Support\Renderable;

abstract class AbstractWidget implements Renderable
{
    /**
     * @param string $id
     * @param array $options
     */
    public function __construct(array $options = [ ])
    {
        foreach ($options as $key => $value) {
            $this->$key = $value;
        }
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