<?php

namespace Kalnoy\Shopping\Filters\Widgets\Options;

use Illuminate\Support\Arr;

class Option
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
}