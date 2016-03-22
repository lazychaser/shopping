<?php

namespace Kalnoy\Shopping\Widgets\Options;

use Illuminate\Support\Arr;

class Option implements \Kalnoy\Shopping\Contracts\Widgets\Option
{
    /**
     * @var string
     */
    public $value;

    /**
     * @var string
     */
    public $title;

    /**
     * @var int
     */
    public $frequency;

    /**
     * @var bool
     */
    public $active;

    /**
     * Option constructor.
     *
     * @param $value
     * @param $title
     * @param int $frequency
     * @param bool $active
     */
    public function __construct($value, $title, $frequency = null, $active = null)
    {
        $this->active = $active;
        $this->frequency = $frequency;
        $this->title = $title;
        $this->value = $value;
    }

    /**
     * @param array $data
     *
     * @return static
     */
    public static function fromArray(array $data)
    {
        return new static(Arr::get($data, 'value'),
                          Arr::get($data, 'title'),
                          Arr::get($data, 'frequency'),
                          Arr::get($data, 'active', null));
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return bool
     */
    public function isActive()
    {
        return $this->active;
    }

    /**
     * @return int
     */
    public function getFrequency()
    {
        return $this->frequency;
    }
}