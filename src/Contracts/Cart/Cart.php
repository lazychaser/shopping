<?php

namespace Kalnoy\Shopping\Contracts\Cart;

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
     * If one is already in cart, the quantity is updated.
     *
     * @param Product $product
     * @param int $qty
     *
     * @return void
     */
    public function put(Product $product, $qty = 1);

    /**
     * Update the quantity for product or list of products.
     *
     * @param array|Product|string $product
     * @param null|int $qty
     *
     * @return void
     */
    public function update($product, $qty = null);

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
     * @return \Illuminate\Support\Collection
     */
    public function items();

    /**
     * Get total price.
     *
     * @return float
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