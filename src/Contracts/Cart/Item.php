<?php

namespace Kalnoy\Shopping\Contracts\Cart;

use Kalnoy\Shopping\Contracts\Commerce\Product;
use Kalnoy\Shopping\Data\Money;

interface Item
{
    /**
     * Get the id of the associated product.
     *
     * @return string
     */
    public function getProductId();

    /**
     * Get the product associated with the item.
     *
     * @return Product
     */
    public function getProduct();

    /**
     * Get quantity.
     *
     * @return int
     */
    public function getQuantity();

    /**
     * Get price for single unit.
     *
     * @return Money
     */
    public function getPrice();

    /**
     * Get the total price.
     *
     * @return Money
     */
    public function getTotalPrice();
}