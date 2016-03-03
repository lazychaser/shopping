<?php

namespace Kalnoy\Shopping\Contracts\Commerce;

use Kalnoy\Shopping\Data\Money;

interface UnitConversion
{
    /**
     * Convert (unless `$convert` is `false`) and format value in target units.
     *
     * @param float $value
     * @param bool $convert
     *
     * @return string
     */
    public function format($value, $convert = true);

    /**
     * Convert value.
     *
     * @param float $value
     * @param bool $inverse
     *
     * @return float
     */
    public function convert($value, $inverse = false);

    /**
     * Convert price in base units to target units.
     *
     * @param Money $money
     *
     * @return Money
     */
    public function convertPrice(Money $money);

    /**
     * @return Unit
     */
    public function getBaseUnit();

    /**
     * @return Unit
     */
    public function getTargetUnit();

    /**
     * @return float
     */
    public function getRatio();
}