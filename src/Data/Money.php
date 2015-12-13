<?php

namespace Kalnoy\Shopping\Data;

class Money
{
    /**
     * @var
     */
    protected $value;

    /**
     * Money constructor.
     *
     * @param int $value
     */
    public function __construct($value)
    {
        $this->value = (int)$value;
    }

    /**
     * @param int $value
     *
     * @return Money
     */
    public static function raw($value)
    {
        return new static($value);
    }

    /**
     * @param $value
     *
     * @return Money
     */
    public static function fromFloat($value)
    {
        return new static(static::round($value * 100));
    }

    /**
     * @param Percents|Money $amount
     *
     * @return Money
     */
    public function add($amount)
    {
        return new static($this->value + $this->getMonetaryAmount($amount));
    }

    /**
     * @param Percents|Money $amount
     *
     * @return Money
     */
    public function sub($amount)
    {
        return new static($this->value - $this->getMonetaryAmount($amount));
    }

    /**
     * Multiplication.
     *
     * Calculates percentage if $value is Percents.
     *
     * @param float|Percents $value
     *
     * @return Money
     */
    public function mul($value)
    {
        if ($value instanceof Percents) {
            $value = $value->toMultiplier();
        }

        return new static(static::round($this->value * $value));
    }

    /**
     * Division.
     *
     * @param float $value
     *
     * @return Money
     */
    public function div($value)
    {
        return new static(static::round($this->value / $value));
    }

    /**
     * @param Percents $percents
     *
     * @return Money
     */
    public function discount(Percents $percents)
    {
        return $this->sub($percents);
    }

    /**
     * Omit cents using half up round.
     *
     * @return Money
     */
    public function omitCents()
    {
        return new static(static::round($this->value, false));
    }

    /**
     * @param Money $b
     *
     * @return bool
     */
    public function eq(Money $b)
    {
        return static::compare($this, $b) == 0;
    }

    /**
     * @param Money $b
     *
     * @return bool
     */
    public function gt(Money $b)
    {
        return static::compare($this, $b) == 1;
    }

    /**
     * @param Money $b
     *
     * @return bool
     */
    public function lt(Money $b)
    {
        return static::compare($this, $b) == -1;
    }

    /**
     * @param Money $b
     *
     * @return bool
     */
    public function lte(Money $b)
    {
        return static::compare($this, $b) <= 0;
    }

    /**
     * @param Money $b
     *
     * @return bool
     */
    public function gte(Money $b)
    {
        return static::compare($this, $b) >= 0;
    }

    /**
     * @return float
     */
    public function toFloat()
    {
        return $this->value * 0.01;
    }

    /**
     * @param mixed $amount
     *
     * @return int
     */
    protected function getMonetaryAmount($amount)
    {
        if ($amount instanceof Percents) {
            return static::round($amount->calcPercentage($this->value));
        }

        if ($amount instanceof Money) {
            return $amount->value;
        }

        throw new \InvalidArgumentException;
    }

    /**
     * @param float $value
     * @param bool $cents
     *
     * @return int
     */
    public static function round($value, $cents = true)
    {
        return (int)round($value, $cents ? 0 : -2);
    }

    /**
     * @param Money $a
     * @param Money $b
     *
     * @return int
     */
    public static function compare(Money $a, Money $b)
    {
        if ($a->value > $b->value) {
            return 1;
        }

        if ($a->value < $b->value) {
            return -1;
        }

        return 0;
    }

}