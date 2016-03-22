<?php

namespace Kalnoy\Shopping\Widgets;

use Kalnoy\Shopping\Contracts\Widgets\Option as OptionContract;

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
     * @param OptionContract $option
     *
     * @return string
     */
    protected function renderOption(OptionContract $option)
    {
        $href = $this->getHref($option);

        $title = $this->html ? $option->getTitle() : e($option->getTitle());

        return '<a href="'.$href.'">'.$title.'</a>';
    }

    /**
     * @param OptionContract $option
     *
     * @return string
     */
    protected function getHref(OptionContract $option)
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
     * @param OptionContract $option
     *
     * @return array
     */
    protected function getLinkParams(OptionContract $option)
    {
        $params = $this->input;
        
        $option = $option->getValue();

        if (is_null($option)) {
            unset($params[$this->id]);

            return $params;
        }

        if ($this->multiple) {
            if (isset($params[$this->id]) &&
                in_array($option, $params[$this->id])
            ) {
                $params[$this->id] = array_diff($params[$this->id], [ $option ]);

                if (empty($params[$this->id])) {
                    unset($params[$this->id]);
                }
            } else {
                $params[$this->id][] = $option;
            }

            return $params;
        }

        if (isset($params[$this->id]) && $params[$this->id] == $option) {
            unset($params[$this->id]);
        } else {
            $params[$this->id] = $option;
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