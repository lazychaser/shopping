<?php

namespace Kalnoy\Shopping\Contracts\Cart;

use Kalnoy\Shopping\Contracts\Commerce\Product;
use Kalnoy\Shopping\Data\Money;

interface Cart extends \IteratorAggregate, \Countable
{
    /**
     * Get whether specified product is in cart.
     *
     * @param string|Product $product
     *
     * @return bool
     */
    public function has($product);

    /**
     * @param string|Product $product
     *
     * @return int
     */
    public function quantity($product);

    /**
     * Put product in cart.
     *
     * If one is already in cart, the quantity is added to the current value.
     *
     * @param Product $product
     * @param int $quantity
     *
     * @return $this
     */
    public function put(Product $product, $quantity = 1);

    /**
     * Update the quantity for the product.
     *
     * The product will be added if not already in the cart.
     *
     * @param Product $product
     * @param int $quantity
     *
     * @return $this
     */
    public function update(Product $product, $quantity);

    /**
     * Update the quantity for the list of products.
     *
     * @param array $data
     *
     * @return $this
     */
    public function updateAll(array $data);

    /**
     * Remove product from cart.
     *
     * @param string|Product $product
     *
     * @return bool
     */
    public function remove($product);

    /**
     * Restore previously removed product.
     *
     * @param string|Product $product
     *
     * @return bool
     */
    public function restore($product);

    /**
     * Clear cart.
     *
     * @return void
     */
    public function clear();

    /**
     * Get items.
     *
     * @return Item[]|\Illuminate\Support\Collection
     */
    public function items();

    /**
     * Get total price.
     *
     * @return Money
     */
    public function total();

    /**
     * Get whether the cart is empty.
     *
     * @return bool
     */
    public function isEmpty();

    /**
     * @param Requirement $requirement
     */
    public function addRequirement(Requirement $requirement);

    /**
     * Get whether every requirement is satisfied.
     *
     * @return bool
     */
    public function requirementsSatisfied();

    /**
     * Get failing requirement.
     *
     * @return Requirement
     */
    public function failedRequirement();

}