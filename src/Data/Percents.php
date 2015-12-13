<?php

namespace Kalnoy\Shopping\Data;

class Percents
{
    /**
     * @var int
     */
    protected $value;

    /**
     * Percents constructor.
     *
     * @param int $value
     */
    public function __construct($value)
    {
        $this->value = (int)$value;
    }

    /**
     * @param float $value
     *
     * @return float
     */
    public function calcPercentage($value)
    {
        return $value * $this->toMultiplier();
    }

    /**
     * @return float
     */
    public function toMultiplier()
    {
        return $this->value * 0.01;
    }
}