<?php

namespace Lazychaser\Shopping\Contracts\Commerce;

use Lazychaser\Shopping\Data\Money;

interface Product
{
    /**
     * @return string
     */
    public function getUniqueId();

    /**
     * @param int $quantity
     *
     * @return Money
     */
    public function getPriceForQuantity($quantity);

    /**
     * Min quantity that customer can add to cart.
     *
     * @return int
     */
    public function getMinQuantity();

    /**
     * Quantity is a multiple of this value.
     *
     * @return int
     */
    public function getQuantityFactor();

    /**
     * Get whether cart item is available for purchase.
     *
     * @return bool
     */
    public function isPurchasable();
}