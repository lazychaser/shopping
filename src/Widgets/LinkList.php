<?php

namespace Kalnoy\Shopping\Widgets;

use Kalnoy\Shopping\Contracts\Widgets\Option as OptionContract;

class LinkList extends AbstractOptionsList
{
    /**
     * @var array
     */
    public $params = [];

    /**
     * @var string
     */
    public $baseUrl;

    /**
     * Set additional parameters that will be appended to the link query params.
     *
     * @param array $params
     *
     * @return $this
     */
    public function params(array $params)
    {
        $this->params = $params;

        return $this;
    }

    /**
     * Append a parameter.
     * 
     * @param string $key
     * @param string $value
     *
     * @return $this
     */
    public function param($key, $value)
    {
        $this->params = array_merge_recursive($this->params, [ $key => $value ]);

        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function baseUrl($value)
    {
        $this->baseUrl = $value;

        return $this;
    }

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

        $params = $params ? '?'.http_build_query($params, null, '&amp;') : '';

        return $this->getBaseUrl().$params;
    }

    /**
     * @return string
     */
    public function getBaseContainerClass()
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
        $params = $this->params;

        unset($params[$this->id]);

        if (is_null($option->getValue())) {
            return $params;
        }

        if ($this->multiple) {
            $activeItems = [];

            foreach ($this->items as $item) {
                if ($item != $option && $item->isActive() ||
                    $item == $option && ! $item->isActive()
                ) {
                    $activeItems[] = $item->getValue();
                }
            }

            if ($activeItems) {
                $params[$this->id] = $activeItems;
            }
        } elseif ( ! $option->isActive()) {
            $params[$this->id] = $option->getValue();
        }

        return $params;
    }

    /**
     * @return string
     */
    public function getBaseUrl()
    {
        if ($this->baseUrl) {
            return $this->baseUrl;
        }

        if ( ! $request = $this->getRequest()) {
            return null;
        }

        return $request->url();
    }
}