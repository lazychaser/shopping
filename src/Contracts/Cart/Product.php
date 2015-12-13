<?php

namespace Kalnoy\Shopping\Contracts\Cart;

/**
 * The interface for a cart item.
 */
interface Product
{
    /**
     * Get the id of cart item.
     *
     * @return mixed
     */
    public function getId();

    /**
     * @return float
     */
    public function getTotalPrice();

    /**
     * Get quantity.
     *
     * @return int
     */
    public function getQuantity();

    /**
     * Set the quantity.
     *
     * @param int $value
     */
    public function setQuantity($value);

    /**
     * @return float
     */
    public function getTotalPieces();

    /**
     * Get whether cart item is available for purchase.
     *
     * @return bool
     */
    public function isPurchasable();

}