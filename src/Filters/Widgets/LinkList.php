<?php

namespace Kalnoy\Shopping\Filters\Widgets;

use Kalnoy\Shopping\Filters\Widgets\Options\Option;

class LinkList extends AbstractOptionsList
{
    /**
     * @var array
     */
    public $input = [];

    /**
     * @var string
     */
    public $baseUrl;

    /**
     * @param Option $option
     *
     * @return string
     */
    protected function renderOption(Option $option)
    {
        $href = $this->getHref($option);

        $title = $this->html ? $option->title : e($option->title);

        return '<a href="'.$href.'">'.$title.'</a>';
    }

    /**
     * @param Option $option
     *
     * @return string
     */
    protected function getHref(Option $option)
    {
        $params = $this->getLinkParams($option);

        $params = $params ? '?'.http_build_query($params) : '';

        return $this->getBaseUrl().$params;
    }

    /**
     * @return string
     */
    protected function getBaseContainerClass()
    {
        return 'LinksFilter';
    }

    /**
     * @param Option $option
     *
     * @return array
     */
    protected function getLinkParams(Option $option)
    {
        $params = $this->input;

        if (is_null($option->value)) {
            unset($params[$this->id]);

            return $params;
        }

        if ($this->multiple) {
            if (isset($params[$this->id]) &&
                in_array($option->value, $params[$this->id])
            ) {
                $params[$this->id] = array_diff($params[$this->id], [ $option->value ]);

                if (empty($params[$this->id])) {
                    unset($params[$this->id]);
                }
            } else {
                $params[$this->id][] = $option->value;
            }

            return $params;
        }

        if (isset($params[$this->id]) && $params[$this->id] == $option->value) {
            unset($params[$this->id]);
        } else {
            $params[$this->id] = $option->value;
        }

        return $params;
    }

    /**
     * @return string
     */
    public function getBaseUrl()
    {
        return $this->baseUrl ?: \Input::url();
    }
}